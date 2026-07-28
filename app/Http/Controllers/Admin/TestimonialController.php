<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::latest()->get();

        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function toggleApproval(Testimonial $testimonial)
    {
        $testimonial->update([
            'is_approved' => !$testimonial->is_approved
        ]);

        $status = $testimonial->is_approved ? 'approved' : 'unapproved';
        return back()->with('success', "Testimonial has been {$status} successfully.");
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_designation' => 'nullable|string|max:255',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'avatar' => 'nullable|image|max:10240',
        ], [
            'avatar.image' => 'The file must be an image.',
            'avatar.max' => 'The file must not be larger than 10MB.',
        ]);

        $data = $request->all();

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = 'testimonials/' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destDir = public_path('storage/testimonials');
            if (!is_dir($destDir)) mkdir($destDir, 0775, true);
            $file->move($destDir, basename($filename));
            $data['avatar_path'] = 'storage/' . $filename;
        }

        Testimonial::create($data);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial added successfully!');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_designation' => 'nullable|string|max:255',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'avatar' => 'nullable|image|max:10240',
        ]);

        $data = $request->all();

        if ($request->hasFile('avatar')) {
            // Delete old avatar
            if ($testimonial->avatar_path) {
                $oldFile = public_path($testimonial->avatar_path);
                if (file_exists($oldFile)) unlink($oldFile);
            }
            $file = $request->file('avatar');
            $filename = 'testimonials/' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destDir = public_path('storage/testimonials');
            if (!is_dir($destDir)) mkdir($destDir, 0775, true);
            $file->move($destDir, basename($filename));
            $data['avatar_path'] = 'storage/' . $filename;
        }

        $testimonial->update($data);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial updated successfully!');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();

        return back()->with('success', 'Testimonial deleted successfully!');
    }
}
