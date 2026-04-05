<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('vendor_profile_id', auth()->user()->vendorProfile->id)->paginate(10);
        return view('dashboard.vendor.products.index', compact('products'));
    }

    public function create()
    {
        return view('dashboard.vendor.products.create');
    }

    public function store(StoreProductRequest $request)
    {
        Product::create($request->validated() + [
            'vendor_profile_id' => auth()->user()->vendorProfile->id,
            'is_active' => true,
        ]);

        return redirect()->route('vendor.products.index')->with('success', __('messages.saved'));
    }

    public function edit(Product $product)
    {
        $this->authorize('update', $product);
        return view('dashboard.vendor.products.edit', compact('product'));
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
