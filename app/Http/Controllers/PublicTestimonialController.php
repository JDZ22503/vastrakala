<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimonial;

class PublicTestimonialController extends Controller
{
    public function create()
    {
        return view('reviews.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_designation' => 'nullable|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
            'avatar' => 'nullable|image|max:10240',
        ]);

        $data = [
            'customer_name' => $request->customer_name,
            'customer_designation' => $request->customer_designation,
            'rating' => $request->rating,
            'content' => $request->comment,
            'is_approved' => false,
        ];
        
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = 'testimonials/' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destDir = public_path('storage/testimonials');
            if (!is_dir($destDir)) mkdir($destDir, 0775, true);
            $file->move($destDir, basename($filename));
            $data['avatar_path'] = 'storage/' . $filename;
        }

        Testimonial::create($data);

        return redirect()->back()->with('success', 'Your review has been submitted and is awaiting approval. Thank you!');
    }
}
