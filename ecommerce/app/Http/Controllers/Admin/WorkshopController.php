<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Workshop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class WorkshopController extends Controller
{
    public function index(Request $request)
    {
        $items = Workshop::with('category')
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = trim((string) $request->q);
                $query->where('title', 'like', '%' . $term . '%')->orWhere('slug', 'like', '%' . $term . '%');
            })
            ->latest('starts_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.shared-index', [
            'items' => $items,
            'title' => 'Workshops',
            'routePrefix' => 'admin.workshops',
            'columns' => [
                ['label' => 'Image', 'key' => 'image_url', 'type' => 'image'],
                ['label' => 'Title', 'key' => 'title'],
                ['label' => 'Category', 'key' => 'category.name'],
                ['label' => 'Location', 'key' => 'location'],
                ['label' => 'Starts at', 'key' => 'starts_at', 'type' => 'datetime'],
                ['label' => 'Capacity', 'key' => 'capacity'],
                ['label' => 'Reserved', 'key' => 'reserved_count'],
                ['label' => 'Featured', 'key' => 'is_featured', 'type' => 'boolean'],
            ],
        ]);
    }

    public function create()
    {
        return view('admin.shared-form', ['title' => 'Create Workshop', 'routePrefix' => 'admin.workshops', 'method' => 'POST', 'item' => new Workshop(), 'fields' => $this->fields()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $this->persistUploads($request, $data);
        $workshop = Workshop::create($data);
        $this->syncGallery($request, $workshop);

        return redirect()->route('admin.workshops.index')->with('success', __('messages.saved'));
    }

    public function show(Workshop $workshop)
    {
        $workshop->load(['category', 'mediaGallery']);

        return view('admin.shared-show', [
            'title' => 'Workshop details',
            'routePrefix' => 'admin.workshops',
            'item' => $workshop,
            'displayFields' => [
                ['label' => 'Image', 'key' => 'image_url', 'type' => 'image'],
                ['label' => 'Title', 'key' => 'title'],
                ['label' => 'Slug', 'key' => 'slug'],
                ['label' => 'Category', 'key' => 'category.name'],
                ['label' => 'Summary', 'key' => 'summary', 'type' => 'multiline'],
                ['label' => 'Description', 'key' => 'description', 'type' => 'multiline'],
                ['label' => 'Location', 'key' => 'location'],
                ['label' => 'Starts at', 'key' => 'starts_at', 'type' => 'datetime'],
                ['label' => 'Ends at', 'key' => 'ends_at', 'type' => 'datetime'],
                ['label' => 'Capacity', 'key' => 'capacity'],
                ['label' => 'Reserved count', 'key' => 'reserved_count'],
                ['label' => 'Price', 'key' => 'price', 'type' => 'money'],
                ['label' => 'Featured', 'key' => 'is_featured', 'type' => 'boolean'],
            ],
        ]);
    }

    public function edit(Workshop $workshop)
    {
        $workshop->load('mediaGallery');

        return view('admin.shared-form', ['title' => 'Edit Workshop', 'routePrefix' => 'admin.workshops', 'method' => 'PUT', 'item' => $workshop, 'fields' => $this->fields()]);
    }

    public function update(Request $request, Workshop $workshop)
    {
        $data = $this->validated($request, $workshop);
        $this->persistUploads($request, $data, $workshop);
        $workshop->update($data);
        $this->syncGallery($request, $workshop);

        return redirect()->route('admin.workshops.edit', $workshop)->with('success', __('messages.updated'));
    }

    public function destroy(Workshop $workshop)
    {
        if ($workshop->image_path) {
            Storage::disk('public')->delete($workshop->image_path);
        }
        foreach ($workshop->mediaGallery as $media) {
            Storage::disk('public')->delete($media->path);
            $media->delete();
        }

        $workshop->delete();

        return redirect()->route('admin.workshops.index')->with('success', __('messages.deleted'));
    }

    private function fields(): array
    {
        return [
            ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'required' => true],
            ['name' => 'slug', 'label' => 'Slug', 'type' => 'text'],
            ['name' => 'category_id', 'label' => 'Category', 'type' => 'select', 'options' => Category::where('type', 'workshop')->orderBy('name')->pluck('name', 'id')->toArray()],
            ['name' => 'summary', 'label' => 'Summary', 'type' => 'textarea'],
            ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'required' => true],
            ['name' => 'location', 'label' => 'Location', 'type' => 'text', 'required' => true],
            ['name' => 'starts_at', 'label' => 'Starts at', 'type' => 'datetime-local', 'required' => true],
            ['name' => 'ends_at', 'label' => 'Ends at', 'type' => 'datetime-local'],
            ['name' => 'capacity', 'label' => 'Capacity', 'type' => 'number', 'required' => true, 'min' => '1'],
            ['name' => 'reserved_count', 'label' => 'Reserved count', 'type' => 'number', 'min' => '0'],
            ['name' => 'price', 'label' => 'Price (TND)', 'type' => 'number', 'required' => true, 'step' => '0.01', 'min' => '0'],
            ['name' => 'image', 'label' => 'Primary image', 'type' => 'image'],
            ['name' => 'gallery_images', 'label' => 'Gallery images', 'type' => 'gallery'],
            ['name' => 'is_featured', 'label' => 'Featured', 'type' => 'checkbox'],
        ];
    }

    private function validated(Request $request, ?Workshop $workshop = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'alpha_dash', Rule::unique('workshops', 'slug')->ignore(optional($workshop)->id)],
            'category_id' => ['nullable', 'exists:categories,id'],
            'summary' => ['nullable', 'string'],
            'description' => ['required', 'string'],
            'location' => ['required', 'string', 'max:255'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
            'capacity' => ['required', 'integer', 'min:1'],
            'reserved_count' => ['nullable', 'integer', 'min:0'],
            'price' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'max:4096'],
            'gallery_images' => ['nullable', 'array'],
            'gallery_images.*' => ['image', 'max:4096'],
            'remove_image' => ['nullable', 'boolean'],
            'remove_gallery' => ['nullable', 'array'],
            'remove_gallery.*' => ['integer'],
            'is_featured' => ['nullable', 'boolean'],
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']) . '-' . now()->format('His');
        }

        $data['reserved_count'] = isset($data['reserved_count']) ? (int) $data['reserved_count'] : 0;
        $data['is_featured'] = $request->boolean('is_featured');

        return $data;
    }

    private function persistUploads(Request $request, array &$data, ?Workshop $workshop = null): void
    {
        if ($request->boolean('remove_image') && $workshop?->image_path) {
            Storage::disk('public')->delete($workshop->image_path);
            $data['image_path'] = null;
        }
        if ($request->hasFile('image')) {
            if ($workshop?->image_path) {
                Storage::disk('public')->delete($workshop->image_path);
            }
            $data['image_path'] = $request->file('image')->store('workshops', 'public');
        }

        unset($data['image'], $data['gallery_images']);
    }

    private function syncGallery(Request $request, Workshop $workshop): void
    {
        $removeIds = collect($request->input('remove_gallery', []))->map(fn ($id) => (int) $id)->all();
        if ($removeIds) {
            $workshop->mediaGallery()->whereIn('id', $removeIds)->get()->each(function ($media) {
                Storage::disk('public')->delete($media->path);
                $media->delete();
            });
        }

        if ($request->hasFile('gallery_images')) {
            $nextOrder = (int) $workshop->mediaGallery()->max('sort_order') + 1;
            foreach ($request->file('gallery_images') as $upload) {
                $workshop->mediaGallery()->create(['path' => $upload->store('workshops/gallery', 'public'), 'sort_order' => $nextOrder++]);
            }
        }
    }
}
