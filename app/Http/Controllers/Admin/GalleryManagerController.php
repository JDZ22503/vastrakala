<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryManagerController extends Controller
{
    public function index()
    {
        $galleries = Gallery::with(['category', 'primaryImage'])->latest()->get();

        return view('admin.gallery.index', compact('galleries'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('admin.gallery.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:3072',
            'badge' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ], [
            'images.required' => 'Please upload at least one image.',
            'images.*.image' => 'The file must be an image.',
            'images.*.mimes' => 'The file must be a valid image format (jpeg, png, jpg, webp).',
            'images.*.max' => 'The file must not be larger than 3MB.',
        ]);

        $gallery = Gallery::create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title).'-'.time(),
            'badge' => $request->badge,
            'description' => $request->description,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {
                $path = $file->store('gallery', 'public');
                $gallery->images()->create([
                    'image_path' => 'storage/'.$path,
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.gallery.index')->with('success', 'New creation added with its photos! ');
    }

    public function edit(Gallery $gallery)
    {
        $categories = Category::all();
        $gallery->load('images');

        return view('admin.gallery.edit', compact('gallery', 'categories'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'badge' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ], [
            'images.required' => 'Please upload at least one image.',
            'images.*.image' => 'The file must be an image.',
            'images.*.mimes' => 'The file must be a valid image format (jpeg, png, jpg, webp).',
            'images.*.max' => 'The file must not be larger than 3MB.',
        ]);

        $gallery->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title).'-'.$gallery->id,
            'badge' => $request->badge,
            'description' => $request->description,
        ]);

        if ($request->hasFile('images')) {
            // Find the current max sort order to append new images at the end
            $maxSort = $gallery->images()->max('sort_order') ?? -1;

            // Store new files (ADDITIVE)
            foreach ($request->file('images') as $index => $file) {
                $path = $file->store('gallery', 'public');
                $gallery->images()->create([
                    'image_path' => 'storage/'.$path,
                    'sort_order' => $maxSort + $index + 1,
                ]);
            }
        }

        return redirect()->route('admin.gallery.index')->with('success', 'Creation updated successfully.');
    }

    public function deletePhoto(GalleryImage $photo)
    {
        // Delete physical file
        Storage::disk('public')->delete(str_replace('storage/', '', $photo->image_path));

        // Delete record
        $photo->delete();

        return response()->json(['success' => true, 'message' => 'Photo deleted!']);
    }

    public function reorderPhotos(Request $request)
    {
        $request->validate(['order' => 'required|array', 'order.*' => 'exists:gallery_images,id']);

        foreach ($request->order as $index => $id) {
            GalleryImage::where('id', $id)->update(['sort_order' => $index]);
        }

        return response()->json(['success' => true, 'message' => 'Order updated!']);
    }

    public function destroy(Gallery $gallery)
    {
        // Delete related photo files
        foreach ($gallery->images as $img) {
            Storage::disk('public')->delete(str_replace('storage/', '', $img->image_path));
        }

        $gallery->delete(); // Cascades to gallery_images table via DB foreign key

        return back()->with('success', 'Creation deleted successfully.');
    }

    public function toggleNewArrival(Gallery $gallery)
    {
        $gallery->new_arrival = ! $gallery->new_arrival;
        $gallery->save();

        $statusMessage = $gallery->new_arrival ? 'marked as New Arrival!' : 'removed from New Arrivals.';

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'is_new_arrival' => $gallery->new_arrival,
                'message' => "Item \"$gallery->title\" has been $statusMessage",
            ]);
        }

        return back()->with('success', "Item \"$gallery->title\" has been $statusMessage");
    }
}
