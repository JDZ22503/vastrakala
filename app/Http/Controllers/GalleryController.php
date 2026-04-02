<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $categories = \App\Models\Category::with('galleries.primaryImage')->get();
        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();

        return view('gallery', compact('categories', 'settings'));
    }

    public function show($slug)
    {
        $item = \App\Models\Gallery::with(['category', 'images'])->where('slug', $slug)->firstOrFail();
        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();

        return view('gallery-show', compact('item', 'settings'));
    }
}
