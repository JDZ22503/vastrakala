<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
        // Fetch only products marked as "New Arrival"
        $galleryItems = \App\Models\Gallery::where('new_arrival', true)->with(['category', 'primaryImage'])->latest()->get();
        // If NO items are marked as new arrival, fallback to latest 6 to keep section from being empty
        if ($galleryItems->isEmpty()) {
            $galleryItems = \App\Models\Gallery::with(['category', 'primaryImage'])->latest()->take(6)->get();
        }
        $categories = \App\Models\Category::all();
        $testimonials = \App\Models\Testimonial::latest()->get();

        return view('home', compact('settings', 'galleryItems', 'categories', 'testimonials'));
    }
}
