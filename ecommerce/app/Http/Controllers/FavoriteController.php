<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Course;
use App\Models\Product;
use App\Models\Workshop;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index(Request $request)
    {
        $favorites = $request->user()->favorites()->with('favoritable')->latest()->paginate(15);

        return view('dashboard.user.favorites', compact('favorites'));
    }

    public function toggle(Request $request)
    {
        $data = $request->validate([
            'type' => ['required', 'string', 'in:product,course,workshop,content'],
            'id' => ['required', 'integer'],
        ]);

        $map = [
            'product' => Product::class,
            'course' => Course::class,
            'workshop' => Workshop::class,
            'content' => Content::class,
        ];

        $modelClass = $map[$data['type']];
        $favoritable = $modelClass::findOrFail($data['id']);

        $favorite = $request->user()->favorites()->where([
            'favoritable_type' => get_class($favoritable),
            'favoritable_id' => $favoritable->id,
        ])->first();

        if ($favorite) {
            $favorite->delete();
            return back()->with('success', __('messages.removed_favorite'));
        }

        $request->user()->favorites()->create([
            'favoritable_type' => get_class($favoritable),
            'favoritable_id' => $favoritable->id,
        ]);

        return back()->with('success', __('messages.added_favorite'));
    }
}
