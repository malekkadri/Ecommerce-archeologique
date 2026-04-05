<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Course;
use App\Models\Product;
use App\Models\Workshop;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.index', [
            'featuredContents' => Content::with('category')->where('is_featured', true)->latest()->take(3)->get(),
            'featuredCourses' => Course::where('is_featured', true)->where('is_published', true)->take(3)->get(),
            'upcomingWorkshops' => Workshop::where('starts_at', '>=', now())->orderBy('starts_at')->take(3)->get(),
            'featuredProducts' => Product::where('is_featured', true)->where('is_active', true)->take(4)->get(),
        ]);
    }
}
