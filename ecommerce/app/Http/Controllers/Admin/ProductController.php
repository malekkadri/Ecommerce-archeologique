<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $items = Product::latest()->paginate(15);
        return view('admin.shared-index', ['items' => $items, 'title' => 'Product']);
    }

    public function create() { return view('admin.shared-form', ['title' => 'Product']); }
    public function store(Request $request) { return back()->with('success', __('messages.saved')); }
    public function show(Product $item) { return view('admin.shared-show', ['item' => $item, 'title' => 'Product']); }
    public function edit(Product $item) { return view('admin.shared-form', ['item' => $item, 'title' => 'Product']); }
    public function update(Request $request, Product $item) { return back()->with('success', __('messages.updated')); }
    public function destroy(Product $item) { $item->delete(); return back()->with('success', __('messages.deleted')); }
}
