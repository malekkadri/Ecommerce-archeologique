<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\VendorProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $items = Product::with(['category', 'vendorProfile'])
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = trim((string) $request->q);
                $query->where(function ($subQuery) use ($term) {
                    $subQuery->where('name', 'like', '%' . $term . '%')
                        ->orWhere('slug', 'like', '%' . $term . '%')
                        ->orWhere('sku', 'like', '%' . $term . '%');
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.shared-index', [
            'items' => $items,
            'title' => 'Products',
            'routePrefix' => 'admin.products',
            'columns' => [
                ['label' => 'Image', 'key' => 'image_url', 'type' => 'image'],
                ['label' => 'Name', 'key' => 'name'],
                ['label' => 'Vendor', 'key' => 'vendorProfile.shop_name'],
                ['label' => 'Category', 'key' => 'category.name'],
                ['label' => 'Price', 'key' => 'price', 'type' => 'money'],
                ['label' => 'Stock', 'key' => 'stock'],
                ['label' => 'Active', 'key' => 'is_active', 'type' => 'boolean'],
            ],
        ]);
    }

    public function create()
    {
        return view('admin.shared-form', [
            'title' => 'Create Product',
            'routePrefix' => 'admin.products',
            'method' => 'POST',
            'item' => new Product(),
            'fields' => $this->fields(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $this->persistUploads($request, $data);

        $product = Product::create($data);
        $this->syncGallery($request, $product);

        return redirect()->route('admin.products.index')->with('success', __('messages.saved'));
    }

    public function show(Product $product)
    {
        $product->load(['category', 'vendorProfile', 'mediaGallery']);

        return view('admin.shared-show', [
            'title' => 'Product details',
            'routePrefix' => 'admin.products',
            'item' => $product,
            'displayFields' => [
                ['label' => 'Image', 'key' => 'image_url', 'type' => 'image'],
                ['label' => 'Name', 'key' => 'name'],
                ['label' => 'Slug', 'key' => 'slug'],
                ['label' => 'SKU', 'key' => 'sku'],
                ['label' => 'Vendor', 'key' => 'vendorProfile.shop_name'],
                ['label' => 'Category', 'key' => 'category.name'],
                ['label' => 'Price', 'key' => 'price', 'type' => 'money'],
                ['label' => 'Stock', 'key' => 'stock'],
                ['label' => 'Featured', 'key' => 'is_featured', 'type' => 'boolean'],
                ['label' => 'Active', 'key' => 'is_active', 'type' => 'boolean'],
                ['label' => 'Description', 'key' => 'description', 'type' => 'multiline'],
            ],
        ]);
    }

    public function edit(Product $product)
    {
        $product->load('mediaGallery');

        return view('admin.shared-form', [
            'title' => 'Edit Product',
            'routePrefix' => 'admin.products',
            'method' => 'PUT',
            'item' => $product,
            'fields' => $this->fields(),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validated($request, $product);
        $this->persistUploads($request, $data, $product);

        $product->update($data);
        $this->syncGallery($request, $product);

        return redirect()->route('admin.products.edit', $product)->with('success', __('messages.updated'));
    }

    public function destroy(Product $product)
    {
        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }

        foreach ($product->mediaGallery as $media) {
            Storage::disk('public')->delete($media->path);
            $media->delete();
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', __('messages.deleted'));
    }

    private function fields(): array
    {
        return [
            ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'required' => true, 'translatable' => true],
            ['name' => 'slug', 'label' => 'Slug', 'type' => 'text'],
            ['name' => 'sku', 'label' => 'SKU', 'type' => 'text'],
            ['name' => 'vendor_profile_id', 'label' => 'Vendor', 'type' => 'select', 'required' => true, 'options' => VendorProfile::orderBy('shop_name')->pluck('shop_name', 'id')->toArray()],
            ['name' => 'category_id', 'label' => 'Category', 'type' => 'select', 'options' => Category::where('type', 'product')->orWhere('type', 'marketplace')->orderBy('name')->pluck('name', 'id')->toArray()],
            ['name' => 'price', 'label' => 'Price (TND)', 'type' => 'number', 'required' => true, 'step' => '0.01', 'min' => '0'],
            ['name' => 'stock', 'label' => 'Stock', 'type' => 'number', 'required' => true, 'min' => '0'],
            ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'translatable' => true],
            ['name' => 'image', 'label' => 'Primary image', 'type' => 'image'],
            ['name' => 'gallery_images', 'label' => 'Gallery images', 'type' => 'gallery'],
            ['name' => 'is_featured', 'label' => 'Featured product', 'type' => 'checkbox'],
            ['name' => 'is_active', 'label' => 'Active', 'type' => 'checkbox'],
        ];
    }

    private function validated(Request $request, ?Product $product = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'array'],
            'name.fr' => ['required', 'string', 'max:255'],
            'name.en' => ['nullable', 'string', 'max:255'],
            'name.ar' => ['nullable', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'alpha_dash', Rule::unique('products', 'slug')->ignore(optional($product)->id)],
            'sku' => ['nullable', 'string', 'max:255', Rule::unique('products', 'sku')->ignore(optional($product)->id)],
            'vendor_profile_id' => ['required', 'exists:vendor_profiles,id'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'array'],
            'description.fr' => ['nullable', 'string'],
            'description.en' => ['nullable', 'string'],
            'description.ar' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:4096'],
            'gallery_images' => ['nullable', 'array'],
            'gallery_images.*' => ['image', 'max:4096'],
            'remove_image' => ['nullable', 'boolean'],
            'remove_gallery' => ['nullable', 'array'],
            'remove_gallery.*' => ['integer'],
            'is_featured' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if (empty($data['slug'])) {
            $defaultName = $data['name']['fr'] ?? $data['name']['en'] ?? 'product';
            $data['slug'] = Str::slug($defaultName) . '-' . now()->format('His');
        }

        $data['name'] = $this->encodeTranslations($data['name']);
        $data['description'] = $this->encodeTranslations($data['description'] ?? []);

        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active', true);

        return $data;
    }

    private function encodeTranslations(array $translations): string
    {
        $normalized = [
            'fr' => trim((string) ($translations['fr'] ?? '')),
            'en' => trim((string) ($translations['en'] ?? '')),
            'ar' => trim((string) ($translations['ar'] ?? '')),
        ];

        return json_encode($normalized, JSON_UNESCAPED_UNICODE);
    }

    private function persistUploads(Request $request, array &$data, ?Product $product = null): void
    {
        if ($request->boolean('remove_image') && $product?->image_path) {
            Storage::disk('public')->delete($product->image_path);
            $data['image_path'] = null;
        }

        if ($request->hasFile('image')) {
            if ($product?->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        unset($data['image'], $data['gallery_images']);
    }

    private function syncGallery(Request $request, Product $product): void
    {
        $removeIds = collect($request->input('remove_gallery', []))->map(fn ($id) => (int) $id)->all();
        if (!empty($removeIds)) {
            $product->mediaGallery()->whereIn('id', $removeIds)->get()->each(function ($media) {
                Storage::disk('public')->delete($media->path);
                $media->delete();
            });
        }

        if ($request->hasFile('gallery_images')) {
            $nextOrder = (int) $product->mediaGallery()->max('sort_order') + 1;
            foreach ($request->file('gallery_images') as $upload) {
                $product->mediaGallery()->create([
                    'path' => $upload->store('products/gallery', 'public'),
                    'sort_order' => $nextOrder++,
                ]);
            }
        }
    }
}
