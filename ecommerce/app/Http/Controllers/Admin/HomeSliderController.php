<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeSliderController extends Controller
{
    public function index(Request $request)
    {
        $items = HomeSlider::query()
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = trim((string) $request->q);
                $query->where('title', 'like', '%' . $term . '%');
            })
            ->orderBy('sort_order')
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.shared-index', [
            'items' => $items,
            'title' => 'Home Sliders',
            'routePrefix' => 'admin.home-sliders',
            'columns' => [
                ['label' => 'Image', 'key' => 'image_url', 'type' => 'image'],
                ['label' => 'Title', 'key' => 'title'],
                ['label' => 'Subtitle', 'key' => 'subtitle'],
                ['label' => 'Order', 'key' => 'sort_order'],
                ['label' => 'Active', 'key' => 'is_active', 'type' => 'boolean'],
            ],
        ]);
    }

    public function create()
    {
        return view('admin.shared-form', [
            'title' => 'Create Home Slider',
            'routePrefix' => 'admin.home-sliders',
            'method' => 'POST',
            'item' => new HomeSlider(),
            'fields' => $this->fields(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request, true);
        $this->persistImage($request, $data);
        HomeSlider::create($data);

        return redirect()->route('admin.home-sliders.index')->with('success', __('messages.saved'));
    }

    public function show(HomeSlider $homeSlider)
    {
        return view('admin.shared-show', [
            'title' => 'Home slider details',
            'routePrefix' => 'admin.home-sliders',
            'item' => $homeSlider,
            'displayFields' => [
                ['label' => 'Image', 'key' => 'image_url', 'type' => 'image'],
                ['label' => 'Title', 'key' => 'title'],
                ['label' => 'Subtitle', 'key' => 'subtitle', 'type' => 'multiline'],
                ['label' => 'Order', 'key' => 'sort_order'],
                ['label' => 'Active', 'key' => 'is_active', 'type' => 'boolean'],
            ],
        ]);
    }

    public function edit(HomeSlider $homeSlider)
    {
        return view('admin.shared-form', [
            'title' => 'Edit Home Slider',
            'routePrefix' => 'admin.home-sliders',
            'method' => 'PUT',
            'item' => $homeSlider,
            'fields' => $this->fields(),
        ]);
    }

    public function update(Request $request, HomeSlider $homeSlider)
    {
        $data = $this->validated($request, false);
        $this->persistImage($request, $data, $homeSlider);
        $homeSlider->update($data);

        return redirect()->route('admin.home-sliders.edit', $homeSlider)->with('success', __('messages.updated'));
    }

    public function destroy(HomeSlider $homeSlider)
    {
        if ($homeSlider->image_path && !str_starts_with($homeSlider->image_path, 'http')) {
            Storage::disk('public')->delete($homeSlider->image_path);
        }

        $homeSlider->delete();

        return redirect()->route('admin.home-sliders.index')->with('success', __('messages.deleted'));
    }

    private function fields(): array
    {
        return [
            ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'required' => true, 'translatable' => true],
            ['name' => 'subtitle', 'label' => 'Subtitle', 'type' => 'textarea', 'translatable' => true],
            ['name' => 'image_path', 'label' => 'Slide image', 'type' => 'image', 'required' => true],
            ['name' => 'sort_order', 'label' => 'Display order', 'type' => 'number', 'min' => 0],
            ['name' => 'is_active', 'label' => 'Active', 'type' => 'checkbox'],
        ];
    }

    private function validated(Request $request, bool $isCreate): array
    {
        $data = $request->validate([
            'title' => ['required', 'array'],
            'title.fr' => ['required', 'string', 'max:255'],
            'title.en' => ['nullable', 'string', 'max:255'],
            'title.ar' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'array'],
            'subtitle.fr' => ['nullable', 'string'],
            'subtitle.en' => ['nullable', 'string'],
            'subtitle.ar' => ['nullable', 'string'],
            'image_path' => [$isCreate ? 'required' : 'nullable', 'image', 'max:4096'],
            'remove_image' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['title'] = $this->encodeTranslations($data['title']);
        $data['subtitle'] = $this->encodeTranslations($data['subtitle'] ?? []);
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }

    private function persistImage(Request $request, array &$data, ?HomeSlider $homeSlider = null): void
    {
        if ($request->boolean('remove_image') && $homeSlider?->image_path && !str_starts_with($homeSlider->image_path, 'http')) {
            Storage::disk('public')->delete($homeSlider->image_path);
            $data['image_path'] = null;
        }

        if ($request->hasFile('image_path')) {
            if ($homeSlider?->image_path && !str_starts_with($homeSlider->image_path, 'http')) {
                Storage::disk('public')->delete($homeSlider->image_path);
            }

            $data['image_path'] = $request->file('image_path')->store('home-sliders', 'public');
        }

        if (empty($data['image_path'])) {
            $data['image_path'] = $homeSlider?->image_path;
        }
    }

    private function encodeTranslations(array $translations): string
    {
        return json_encode([
            'fr' => trim((string) ($translations['fr'] ?? '')),
            'en' => trim((string) ($translations['en'] ?? '')),
            'ar' => trim((string) ($translations['ar'] ?? '')),
        ], JSON_UNESCAPED_UNICODE);
    }
}
