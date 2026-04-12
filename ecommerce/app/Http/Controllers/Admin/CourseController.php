<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $items = Course::with('category')
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = trim((string) $request->q);
                $query->where('title', 'like', '%' . $term . '%')->orWhere('slug', 'like', '%' . $term . '%');
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.shared-index', [
            'items' => $items,
            'title' => 'Courses',
            'routePrefix' => 'admin.courses',
            'columns' => [
                ['label' => 'Image', 'key' => 'image_url', 'type' => 'image'],
                ['label' => 'Title', 'key' => 'title'],
                ['label' => 'Category', 'key' => 'category.name'],
                ['label' => 'Level', 'key' => 'level'],
                ['label' => 'Price', 'key' => 'price', 'type' => 'money'],
                ['label' => 'Published', 'key' => 'is_published', 'type' => 'boolean'],
                ['label' => 'Featured', 'key' => 'is_featured', 'type' => 'boolean'],
            ],
        ]);
    }

    public function create()
    {
        return view('admin.shared-form', ['title' => 'Create Course', 'routePrefix' => 'admin.courses', 'method' => 'POST', 'item' => new Course(), 'fields' => $this->fields()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $this->persistUploads($request, $data);
        $course = Course::create($data);
        $this->syncGallery($request, $course);

        return redirect()->route('admin.courses.index')->with('success', __('messages.saved'));
    }

    public function show(Course $course)
    {
        $course->load(['category', 'mediaGallery']);

        return view('admin.shared-show', [
            'title' => 'Course details',
            'routePrefix' => 'admin.courses',
            'item' => $course,
            'displayFields' => [
                ['label' => 'Image', 'key' => 'image_url', 'type' => 'image'],
                ['label' => 'Title', 'key' => 'title'],
                ['label' => 'Slug', 'key' => 'slug'],
                ['label' => 'Category', 'key' => 'category.name'],
                ['label' => 'Summary', 'key' => 'summary', 'type' => 'multiline'],
                ['label' => 'Description', 'key' => 'description', 'type' => 'multiline'],
                ['label' => 'Level', 'key' => 'level'],
                ['label' => 'Price', 'key' => 'price', 'type' => 'money'],
                ['label' => 'Published', 'key' => 'is_published', 'type' => 'boolean'],
                ['label' => 'Featured', 'key' => 'is_featured', 'type' => 'boolean'],
            ],
        ]);
    }

    public function edit(Course $course)
    {
        $course->load('mediaGallery');

        return view('admin.shared-form', ['title' => 'Edit Course', 'routePrefix' => 'admin.courses', 'method' => 'PUT', 'item' => $course, 'fields' => $this->fields()]);
    }

    public function update(Request $request, Course $course)
    {
        $data = $this->validated($request, $course);
        $this->persistUploads($request, $data, $course);
        $course->update($data);
        $this->syncGallery($request, $course);

        return redirect()->route('admin.courses.edit', $course)->with('success', __('messages.updated'));
    }

    public function destroy(Course $course)
    {
        if ($course->image_path) {
            Storage::disk('public')->delete($course->image_path);
        }
        foreach ($course->mediaGallery as $media) {
            Storage::disk('public')->delete($media->path);
            $media->delete();
        }

        $course->delete();

        return redirect()->route('admin.courses.index')->with('success', __('messages.deleted'));
    }

    private function fields(): array
    {
        return [
            ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'required' => true],
            ['name' => 'slug', 'label' => 'Slug', 'type' => 'text'],
            ['name' => 'category_id', 'label' => 'Category', 'type' => 'select', 'options' => Category::where('type', 'course')->orderBy('name')->pluck('name', 'id')->toArray()],
            ['name' => 'summary', 'label' => 'Summary', 'type' => 'textarea'],
            ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'required' => true],
            ['name' => 'level', 'label' => 'Level', 'type' => 'select', 'required' => true, 'options' => ['beginner' => 'Beginner', 'intermediate' => 'Intermediate', 'advanced' => 'Advanced']],
            ['name' => 'price', 'label' => 'Price (TND)', 'type' => 'number', 'required' => true, 'step' => '0.01', 'min' => '0'],
            ['name' => 'image', 'label' => 'Primary image', 'type' => 'image'],
            ['name' => 'gallery_images', 'label' => 'Gallery images', 'type' => 'gallery'],
            ['name' => 'is_published', 'label' => 'Published', 'type' => 'checkbox'],
            ['name' => 'is_featured', 'label' => 'Featured', 'type' => 'checkbox'],
        ];
    }

    private function validated(Request $request, ?Course $course = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'alpha_dash', Rule::unique('courses', 'slug')->ignore(optional($course)->id)],
            'category_id' => ['nullable', 'exists:categories,id'],
            'summary' => ['nullable', 'string'],
            'description' => ['required', 'string'],
            'level' => ['required', Rule::in(['beginner', 'intermediate', 'advanced'])],
            'price' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'max:4096'],
            'gallery_images' => ['nullable', 'array'],
            'gallery_images.*' => ['image', 'max:4096'],
            'remove_image' => ['nullable', 'boolean'],
            'remove_gallery' => ['nullable', 'array'],
            'remove_gallery.*' => ['integer'],
            'is_published' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']) . '-' . now()->format('His');
        }

        $data['is_published'] = $request->boolean('is_published', true);
        $data['is_featured'] = $request->boolean('is_featured');

        return $data;
    }

    private function persistUploads(Request $request, array &$data, ?Course $course = null): void
    {
        if ($request->boolean('remove_image') && $course?->image_path) {
            Storage::disk('public')->delete($course->image_path);
            $data['image_path'] = null;
        }
        if ($request->hasFile('image')) {
            if ($course?->image_path) {
                Storage::disk('public')->delete($course->image_path);
            }
            $data['image_path'] = $request->file('image')->store('courses', 'public');
        }

        unset($data['image'], $data['gallery_images']);
    }

    private function syncGallery(Request $request, Course $course): void
    {
        $removeIds = collect($request->input('remove_gallery', []))->map(fn ($id) => (int) $id)->all();
        if ($removeIds) {
            $course->mediaGallery()->whereIn('id', $removeIds)->get()->each(function ($media) {
                Storage::disk('public')->delete($media->path);
                $media->delete();
            });
        }

        if ($request->hasFile('gallery_images')) {
            $nextOrder = (int) $course->mediaGallery()->max('sort_order') + 1;
            foreach ($request->file('gallery_images') as $upload) {
                $course->mediaGallery()->create(['path' => $upload->store('courses/gallery', 'public'), 'sort_order' => $nextOrder++]);
            }
        }
    }
}
