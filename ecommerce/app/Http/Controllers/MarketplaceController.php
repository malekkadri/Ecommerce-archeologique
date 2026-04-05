<?php

namespace App\Http\Controllers;

use App\Models\Product;

class MarketplaceController extends Controller
{
    public function index()
    {
        $query = Product::with(['category', 'vendorProfile'])->where('is_active', true);

        if (request('q')) {
            $query->where('name', 'like', '%' . request('q') . '%');
        }

        return view('marketplace.index', [
            'products' => $query->latest()->paginate(12)->withQueryString(),
        ]);
    }

    public function show($slug)
    {
        $product = Product::with(['category', 'vendorProfile'])->where('slug', $slug)->firstOrFail();
        return view('marketplace.show', compact('product'));
    }
}
