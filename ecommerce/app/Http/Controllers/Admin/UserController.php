<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $items = User::latest()->paginate(15);
        return view('admin.shared-index', ['items' => $items, 'title' => 'User']);
    }

    public function create() { return view('admin.shared-form', ['title' => 'User']); }
    public function store(Request $request) { return back()->with('success', __('messages.saved')); }
    public function show(User $item) { return view('admin.shared-show', ['item' => $item, 'title' => 'User']); }
    public function edit(User $item) { return view('admin.shared-form', ['item' => $item, 'title' => 'User']); }
    public function update(Request $request, User $item) { return back()->with('success', __('messages.updated')); }
    public function destroy(User $item) { $item->delete(); return back()->with('success', __('messages.deleted')); }
}
