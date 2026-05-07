<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $categories = \App\Models\Category::with('galleries.primaryImage')->get();

        return view('gallery', compact('categories'));
    }

    public function show($slug)
    {
        $item = \App\Models\Gallery::with(['category', 'images'])->where('slug', $slug)->firstOrFail();
        
        // Item 8: Cross-Selling (Relatable items)
        $relatedItems = \App\Models\Gallery::where('category_id', $item->category_id)
            ->where('id', '!=', $item->id)
            ->with(['category', 'primaryImage'])
            ->take(4)
            ->get();

        return view('gallery-show', compact('item', 'relatedItems'));
    }
}
