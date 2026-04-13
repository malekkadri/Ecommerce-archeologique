<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Product;
use App\Models\Workshop;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class FrontofficeChatbotController extends Controller
{
    private const MAX_HISTORY_MESSAGES = 12;
    private const CONTEXT_ITEMS_LIMIT = 6;

    public function __invoke(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
            'history' => ['nullable', 'array', 'max:12'],
            'history.*.role' => ['required_with:history', 'string', 'in:user,assistant'],
            'history.*.content' => ['required_with:history', 'string', 'max:2000'],
        ]);

        $apiKey = config('services.groq.api_key');

        if (empty($apiKey)) {
            return response()->json([
                'message' => 'Groq API key is not configured on the server.',
            ], 503);
        }

        $history = array_slice($validated['history'] ?? [], -self::MAX_HISTORY_MESSAGES);

        // The front-end currently sends the latest user message in `history`
        // and as `message`. Keep only one copy for better model quality.
        if (! empty($history)) {
            $lastHistoryMessage = $history[array_key_last($history)];

            if (($lastHistoryMessage['role'] ?? null) === 'user'
                && trim((string) ($lastHistoryMessage['content'] ?? '')) === trim($validated['message'])) {
                array_pop($history);
            }
        }

        $messages = [
            [
                'role' => 'system',
                'content' => config('services.groq.system_prompt', 'You are a helpful assistant for this website. Keep answers concise and practical.'),
            ],
            [
                'role' => 'system',
                'content' => $this->buildProjectContextPrompt($validated['message']),
            ],
        ];

        foreach ($history as $historyMessage) {
            $messages[] = [
                'role' => $historyMessage['role'],
                'content' => $historyMessage['content'],
            ];
        }

        $messages[] = [
            'role' => 'user',
            'content' => $validated['message'],
        ];

        try {
            $response = Http::withToken($apiKey)
                ->withOptions([
                    'connect_timeout' => (int) config('services.groq.connect_timeout', 5),
                ])
                ->timeout((int) config('services.groq.timeout', 20))
                ->retry((int) config('services.groq.retries', 1), 250)
                ->acceptJson()
                ->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => config('services.groq.model', 'llama-3.3-70b-versatile'),
                    'messages' => $messages,
                    'temperature' => 0.5,
                ]);

            if ($response->failed()) {
                Log::warning('Groq chatbot request failed', [
                    'status' => $response->status(),
                    'body' => $response->json() ?? $response->body(),
                ]);

                return response()->json([
                    'message' => 'The assistant is temporarily unavailable. Please try again.',
                ], 502);
            }

            return response()->json([
                'reply' => trim((string) data_get($response->json(), 'choices.0.message.content', '')),
            ]);
        } catch (\Throwable $exception) {
            Log::error('Groq chatbot exception', [
                'error' => $exception->getMessage(),
            ]);

            return response()->json([
                'message' => 'The assistant is temporarily unavailable. Please try again later.',
            ], 500);
        }
    }

    private function buildProjectContextPrompt(string $userMessage): string
    {
        $courses = Course::query()
            ->withCount('lessons')
            ->with('category:id,name')
            ->where('is_published', true)
            ->latest('id')
            ->limit(self::CONTEXT_ITEMS_LIMIT * 2)
            ->get();

        $workshops = Workshop::query()
            ->with('category:id,name')
            ->where('starts_at', '>=', now()->subDay())
            ->latest('starts_at')
            ->limit(self::CONTEXT_ITEMS_LIMIT * 2)
            ->get();

        $products = Product::query()
            ->with('category:id,name')
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->latest('id')
            ->limit(self::CONTEXT_ITEMS_LIMIT * 2)
            ->get();

        $rankedCourses = $this->rankByRelevance($courses, $userMessage, ['title', 'summary', 'description']);
        $rankedWorkshops = $this->rankByRelevance($workshops, $userMessage, ['title', 'summary', 'description', 'location']);
        $rankedProducts = $this->rankByRelevance($products, $userMessage, ['name', 'description']);

        $coursesSummary = $rankedCourses->map(function (Course $course): string {
            return sprintf(
                '- %s | level: %s | lessons: %d | price: %s TND | url: %s',
                $course->title,
                $course->level ?: 'N/A',
                $course->lessons_count,
                number_format((float) $course->price, 2),
                route('courses.show', ['slug' => $course->slug])
            );
        })->implode("\n");

        $workshopsSummary = $rankedWorkshops->map(function (Workshop $workshop): string {
            $seatsLeft = max(0, (int) $workshop->capacity - (int) $workshop->reserved_count);

            return sprintf(
                '- %s | date: %s | location: %s | seats left: %d | price: %s TND | url: %s',
                $workshop->title,
                optional($workshop->starts_at)->format('Y-m-d H:i') ?: 'TBA',
                $workshop->location ?: 'TBA',
                $seatsLeft,
                number_format((float) $workshop->price, 2),
                route('workshops.show', ['slug' => $workshop->slug])
            );
        })->implode("\n");

        $productsSummary = $rankedProducts->map(function (Product $product): string {
            return sprintf(
                '- %s | stock: %d | price: %s TND | url: %s',
                $product->name,
                (int) $product->stock,
                number_format((float) $product->price, 2),
                route('marketplace.show', ['slug' => $product->slug])
            );
        })->implode("\n");

        return <<<PROMPT
You are the MIDA shopping and learning assistant.
Use ONLY this catalog snapshot to recommend the best options for the user.
When the user asks for advice, propose 1-3 specific choices with short reasons and include direct links.
Prefer matching courses/workshops/products to the user's goals, level, budget, and timing.
If information is missing, ask one short follow-up question before recommending.

Available courses:
{$coursesSummary}

Available workshops:
{$workshopsSummary}

Available products:
{$productsSummary}
PROMPT;
    }

    private function rankByRelevance($items, string $userMessage, array $fields)
    {
        $keywords = collect(preg_split('/\s+/', Str::lower($userMessage) ?: ''))
            ->map(fn (string $token) => trim($token))
            ->filter(fn (string $token) => Str::length($token) >= 3)
            ->unique()
            ->values();

        return $items
            ->map(function ($item) use ($keywords, $fields) {
                $haystack = collect($fields)
                    ->map(fn (string $field) => Str::lower((string) data_get($item, $field, '')))
                    ->push(Str::lower((string) data_get($item, 'category.name', '')))
                    ->implode(' ');

                $score = $keywords->reduce(function (int $carry, string $keyword) use ($haystack) {
                    return $carry + (Str::contains($haystack, $keyword) ? 1 : 0);
                }, 0);

                $item->chatbot_relevance_score = $score;

                return $item;
            })
            ->sortByDesc('chatbot_relevance_score')
            ->take(self::CONTEXT_ITEMS_LIMIT)
            ->values();
    }
}
