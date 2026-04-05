<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function index()
    {
        $items = Content::latest()->paginate(15);
        return view('admin.shared-index', ['items' => $items, 'title' => 'Content']);
    }

    public function create() { return view('admin.shared-form', ['title' => 'Content']); }
    public function store(Request $request) { return back()->with('success', __('messages.saved')); }
    public function show(Content $item) { return view('admin.shared-show', ['item' => $item, 'title' => 'Content']); }
    public function edit(Content $item) { return view('admin.shared-form', ['item' => $item, 'title' => 'Content']); }
    public function update(Request $request, Content $item) { return back()->with('success', __('messages.updated')); }
    public function destroy(Content $item) { $item->delete(); return back()->with('success', __('messages.deleted')); }
}
