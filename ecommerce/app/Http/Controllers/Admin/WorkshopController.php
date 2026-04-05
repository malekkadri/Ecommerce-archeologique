<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Workshop;
use Illuminate\Http\Request;
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
        return view('admin.shared-form', [
            'title' => 'Create Workshop',
            'routePrefix' => 'admin.workshops',
            'method' => 'POST',
            'item' => new Workshop(),
            'fields' => $this->fields(),
        ]);
    }

    public function store(Request $request)
    {
        Workshop::create($this->validated($request));

        return redirect()->route('admin.workshops.index')->with('success', __('messages.saved'));
    }

    public function show(Workshop $workshop)
    {
        $workshop->load('category');

        return view('admin.shared-show', [
            'title' => 'Workshop details',
            'routePrefix' => 'admin.workshops',
            'item' => $workshop,
            'displayFields' => [
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
        return view('admin.shared-form', [
            'title' => 'Edit Workshop',
            'routePrefix' => 'admin.workshops',
            'method' => 'PUT',
            'item' => $workshop,
            'fields' => $this->fields(),
        ]);
    }

    public function update(Request $request, Workshop $workshop)
    {
        $workshop->update($this->validated($request, $workshop));

        return redirect()->route('admin.workshops.edit', $workshop)->with('success', __('messages.updated'));
    }

    public function destroy(Workshop $workshop)
    {
        $workshop->delete();

        return redirect()->route('admin.workshops.index')->with('success', __('messages.deleted'));
    }

    private function fields()
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
            ['name' => 'is_featured', 'label' => 'Featured', 'type' => 'checkbox'],
        ];
    }

    private function validated(Request $request, ?Workshop $workshop = null)
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
            'is_featured' => ['nullable', 'boolean'],
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']) . '-' . now()->format('His');
        }

        $data['reserved_count'] = isset($data['reserved_count']) ? (int) $data['reserved_count'] : 0;
        $data['is_featured'] = $request->boolean('is_featured');

        return $data;
    }
}
