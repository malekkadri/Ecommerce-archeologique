<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FrontofficeChatbotController extends Controller
{
    private const MAX_HISTORY_MESSAGES = 12;

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
                ->connectTimeout((int) config('services.groq.connect_timeout', 5))
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
}
