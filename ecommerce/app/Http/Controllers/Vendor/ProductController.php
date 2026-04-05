<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $vendor = auth()->user()->vendorProfile;
        $products = Product::with('category')
            ->where('vendor_profile_id', $vendor->id)
            ->when(request('q'), function ($query) {
                $query->where(function ($inner) {
                    $inner->where('name', 'like', '%' . request('q') . '%')
                        ->orWhere('sku', 'like', '%' . request('q') . '%');
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('dashboard.vendor.products.index', compact('products'));
    }

    public function create()
    {
        return view('dashboard.vendor.products.create', [
            'categories' => Category::where('type', 'marketplace')->orWhere('type', 'content')->get(),
        ]);
    }

    public function store(StoreProductRequest $request)
    {
        Product::create($request->validated() + [
            'vendor_profile_id' => auth()->user()->vendorProfile->id,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('vendor.products.index')->with('success', __('messages.saved'));
    }

    public function edit(Product $product)
    {
        $this->authorize('update', $product);
        return view('dashboard.vendor.products.edit', [
            'product' => $product,
            'categories' => Category::where('type', 'marketplace')->orWhere('type', 'content')->get(),
        ]);
    }

    public function update(StoreProductRequest $request, Product $product)
    {
        $this->authorize('update', $product);
        $product->update($request->validated());
        return back()->with('success', __('messages.updated'));
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);
        $product->delete();
        return back()->with('success', __('messages.deleted'));
    }
}
