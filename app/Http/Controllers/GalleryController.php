<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Gallery;


class GalleryController extends Controller
{
    public function index()
    {
        $categories = Category::with(['galleries' => function ($query) {
            $query->with('primaryImage')->latest();
        }])->orderBy('sort_order', 'asc')->get();

        return view('gallery', compact('categories'));
    }

    public function show($slug)
    {
        $item = Gallery::with(['category', 'images'])->where('slug', $slug)->firstOrFail();
        $relatedItems = Gallery::where('category_id', $item->category_id)
            ->where('id', '!=', $item->id)
            ->with(['category', 'primaryImage'])
            ->latest('id')
            ->take(4)
            ->get();

        return view('gallery-show', compact('item', 'relatedItems'));
    }
}
