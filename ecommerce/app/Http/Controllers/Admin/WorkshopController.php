<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Workshop;
use Illuminate\Http\Request;

class WorkshopController extends Controller
{
    public function index()
    {
        $items = Workshop::latest()->paginate(15);
        return view('admin.shared-index', ['items' => $items, 'title' => 'Workshop']);
    }

    public function create() { return view('admin.shared-form', ['title' => 'Workshop']); }
    public function store(Request $request) { return back()->with('success', __('messages.saved')); }
    public function show(Workshop $item) { return view('admin.shared-show', ['item' => $item, 'title' => 'Workshop']); }
    public function edit(Workshop $item) { return view('admin.shared-form', ['item' => $item, 'title' => 'Workshop']); }
    public function update(Request $request, Workshop $item) { return back()->with('success', __('messages.updated')); }
    public function destroy(Workshop $item) { $item->delete(); return back()->with('success', __('messages.deleted')); }
}
