<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Content;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ContentController extends Controller
{
    public function index(Request $request)
    {
        $items = Content::with(['category', 'author'])
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = trim((string) $request->q);
                $query->where('title', 'like', '%' . $term . '%')->orWhere('slug', 'like', '%' . $term . '%');
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.shared-index', [
            'items' => $items,
            'title' => 'Contents',
            'routePrefix' => 'admin.contents',
            'columns' => [
                ['label' => 'Cover', 'key' => 'featured_image_url', 'type' => 'image'],
                ['label' => 'Title', 'key' => 'title'],
                ['label' => 'Author', 'key' => 'author.name'],
                ['label' => 'Category', 'key' => 'category.name'],
                ['label' => 'Type', 'key' => 'type'],
                ['label' => 'Featured', 'key' => 'is_featured', 'type' => 'boolean'],
                ['label' => 'Published at', 'key' => 'published_at', 'type' => 'datetime'],
            ],
        ]);
    }

    public function create()
    {
        return view('admin.shared-form', ['title' => 'Create Content', 'routePrefix' => 'admin.contents', 'method' => 'POST', 'item' => new Content(), 'fields' => $this->fields()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $this->persistImage($request, $data);
        Content::create($data);

        return redirect()->route('admin.contents.index')->with('success', __('messages.saved'));
    }

    public function show(Content $content)
    {
        $content->load(['category', 'author']);

        return view('admin.shared-show', [
            'title' => 'Content details',
            'routePrefix' => 'admin.contents',
            'item' => $content,
            'displayFields' => [
                ['label' => 'Cover', 'key' => 'featured_image_url', 'type' => 'image'],
                ['label' => 'Title', 'key' => 'title'],
                ['label' => 'Slug', 'key' => 'slug'],
                ['label' => 'Author', 'key' => 'author.name'],
                ['label' => 'Category', 'key' => 'category.name'],
                ['label' => 'Type', 'key' => 'type'],
                ['label' => 'Excerpt', 'key' => 'excerpt', 'type' => 'multiline'],
                ['label' => 'Body', 'key' => 'body', 'type' => 'multiline'],
                ['label' => 'Featured', 'key' => 'is_featured', 'type' => 'boolean'],
                ['label' => 'Published at', 'key' => 'published_at', 'type' => 'datetime'],
            ],
        ]);
    }

    public function edit(Content $content)
    {
        return view('admin.shared-form', ['title' => 'Edit Content', 'routePrefix' => 'admin.contents', 'method' => 'PUT', 'item' => $content, 'fields' => $this->fields()]);
    }

    public function update(Request $request, Content $content)
    {
        $data = $this->validated($request, $content);
        $this->persistImage($request, $data, $content);
        $content->update($data);

        return redirect()->route('admin.contents.edit', $content)->with('success', __('messages.updated'));
    }

    public function destroy(Content $content)
    {
        if ($content->featured_image && !str_starts_with($content->featured_image, 'http')) {
            Storage::disk('public')->delete($content->featured_image);
        }

        $content->delete();

        return redirect()->route('admin.contents.index')->with('success', __('messages.deleted'));
    }

    private function fields(): array
    {
        return [
            ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'required' => true],
            ['name' => 'slug', 'label' => 'Slug', 'type' => 'text'],
            ['name' => 'author_id', 'label' => 'Author', 'type' => 'select', 'required' => true, 'options' => User::orderBy('name')->pluck('name', 'id')->toArray()],
            ['name' => 'category_id', 'label' => 'Category', 'type' => 'select', 'options' => Category::where('type', 'content')->orderBy('name')->pluck('name', 'id')->toArray()],
            ['name' => 'type', 'label' => 'Type', 'type' => 'select', 'required' => true, 'options' => ['recipe' => 'Recipe', 'article' => 'Article', 'tradition' => 'Tradition', 'ingredient' => 'Ingredient', 'nutrition' => 'Nutrition']],
            ['name' => 'excerpt', 'label' => 'Excerpt', 'type' => 'textarea'],
            ['name' => 'body', 'label' => 'Body', 'type' => 'textarea', 'required' => true],
            ['name' => 'featured_image', 'label' => 'Featured image', 'type' => 'image'],
            ['name' => 'published_at', 'label' => 'Published at', 'type' => 'datetime-local'],
            ['name' => 'is_featured', 'label' => 'Featured', 'type' => 'checkbox'],
        ];
    }

    private function validated(Request $request, ?Content $content = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'alpha_dash', Rule::unique('contents', 'slug')->ignore(optional($content)->id)],
            'author_id' => ['required', 'exists:users,id'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'type' => ['required', Rule::in(['recipe', 'article', 'tradition', 'ingredient', 'nutrition'])],
            'excerpt' => ['nullable', 'string'],
            'body' => ['required', 'string'],
            'featured_image' => ['nullable', 'image', 'max:4096'],
            'remove_image' => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],
            'is_featured' => ['nullable', 'boolean'],
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']) . '-' . now()->format('His');
        }

        $data['is_featured'] = $request->boolean('is_featured');

        return $data;
    }

    private function persistImage(Request $request, array &$data, ?Content $content = null): void
    {
        if ($request->boolean('remove_image') && $content?->featured_image && !str_starts_with($content->featured_image, 'http')) {
            Storage::disk('public')->delete($content->featured_image);
            $data['featured_image'] = null;
        }

        if ($request->hasFile('featured_image')) {
            if ($content?->featured_image && !str_starts_with($content->featured_image, 'http')) {
                Storage::disk('public')->delete($content->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('contents', 'public');
        }
    }
}
