<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $items = Course::latest()->paginate(15);
        return view('admin.shared-index', ['items' => $items, 'title' => 'Course']);
    }

    public function create() { return view('admin.shared-form', ['title' => 'Course']); }
    public function store(Request $request) { return back()->with('success', __('messages.saved')); }
    public function show(Course $item) { return view('admin.shared-show', ['item' => $item, 'title' => 'Course']); }
    public function edit(Course $item) { return view('admin.shared-form', ['item' => $item, 'title' => 'Course']); }
    public function update(Request $request, Course $item) { return back()->with('success', __('messages.updated')); }
    public function destroy(Course $item) { $item->delete(); return back()->with('success', __('messages.deleted')); }
}
