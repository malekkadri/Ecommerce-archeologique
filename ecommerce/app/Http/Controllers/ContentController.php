<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Content;

class ContentController extends Controller
{
    public function index()
    {
        $query = Content::with(['category', 'tags'])->whereNotNull('published_at');

        if (request('q')) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . request('q') . '%')
                    ->orWhere('excerpt', 'like', '%' . request('q') . '%');
            });
        }

        if (request('category')) {
            $query->whereHas('category', function ($q) {
                $q->where('slug', request('category'));
            });
        }

        if (request('type')) {
            $query->where('type', request('type'));
        }

        return view('content.index', [
            'contents' => $query->latest('published_at')->paginate(9)->withQueryString(),
            'categories' => Category::where('type', 'content')->get(),
        ]);
    }

    public function show($slug)
    {
        $content = Content::with(['category', 'tags', 'author'])->where('slug', $slug)->firstOrFail();

        return view('content.show', compact('content'));
    }
}
