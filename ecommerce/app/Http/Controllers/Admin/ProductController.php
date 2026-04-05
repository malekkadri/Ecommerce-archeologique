<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\VendorProfile;
use Illuminate\Http\Request;
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
        Product::create($this->validated($request));

        return redirect()->route('admin.products.index')->with('success', __('messages.saved'));
    }

    public function show(Product $product)
    {
        $product->load(['category', 'vendorProfile']);

        return view('admin.shared-show', [
            'title' => 'Product details',
            'routePrefix' => 'admin.products',
            'item' => $product,
            'displayFields' => [
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
        $product->update($this->validated($request, $product));

        return redirect()->route('admin.products.edit', $product)->with('success', __('messages.updated'));
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', __('messages.deleted'));
    }

    private function fields()
    {
        return [
            ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'required' => true],
            ['name' => 'slug', 'label' => 'Slug', 'type' => 'text'],
            ['name' => 'sku', 'label' => 'SKU', 'type' => 'text'],
            ['name' => 'vendor_profile_id', 'label' => 'Vendor', 'type' => 'select', 'required' => true, 'options' => VendorProfile::orderBy('shop_name')->pluck('shop_name', 'id')->toArray()],
            ['name' => 'category_id', 'label' => 'Category', 'type' => 'select', 'options' => Category::where('type', 'product')->orderBy('name')->pluck('name', 'id')->toArray()],
            ['name' => 'price', 'label' => 'Price (TND)', 'type' => 'number', 'required' => true, 'step' => '0.01', 'min' => '0'],
            ['name' => 'stock', 'label' => 'Stock', 'type' => 'number', 'required' => true, 'min' => '0'],
            ['name' => 'description', 'label' => 'Description', 'type' => 'textarea'],
            ['name' => 'is_featured', 'label' => 'Featured product', 'type' => 'checkbox'],
            ['name' => 'is_active', 'label' => 'Active', 'type' => 'checkbox'],
        ];
    }

    private function validated(Request $request, ?Product $product = null)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'alpha_dash', Rule::unique('products', 'slug')->ignore(optional($product)->id)],
            'sku' => ['nullable', 'string', 'max:255', Rule::unique('products', 'sku')->ignore(optional($product)->id)],
            'vendor_profile_id' => ['required', 'exists:vendor_profiles,id'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            'is_featured' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']) . '-' . now()->format('His');
        }

        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active', true);

        return $data;
    }
}
