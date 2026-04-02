<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        \App\Models\User::updateOrCreate(['email' => 'admin@admin.com'], [
            'name' => 'Ayush Admin',
            'password' => bcrypt('admin123'),
        ]);

        // Categories
        $categories = [
            ['name' => 'Baby T-Shirt Designs', 'slug' => 't-shirt'],
            ['name' => 'Paraniu Designs', 'slug' => 'paraniu'],
            ['name' => 'Godadi Designs', 'slug' => 'godadi'],
            ['name' => 'Kanku Pagla Rumal', 'slug' => 'rumal'],
            ['name' => 'Custom Name Designs', 'slug' => 'custom-name'],
        ];

        foreach ($categories as $cat) {
            \App\Models\Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        // Settings
        $settings = [
            'address' => 'Surat, Gujarat, India',
            'phone' => '+91 98765 43210',
            'whatsapp' => '919876543210',
            'instagram' => 'https://instagram.com/littlebabycreations',
            'email' => 'contact@littlebaby.com',
        ];

        foreach ($settings as $key => $value) {
            \App\Models\Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        // Initial Gallery Items (Matching placeholders for now)
        $catTshirt = \App\Models\Category::where('slug', 't-shirt')->first();
        \App\Models\Gallery::updateOrCreate(['title' => 'Sample T-Shirt'], [
            'category_id' => $catTshirt->id,
            'image_path' => 'assets/tshirt.png',
            'badge' => 'Best Seller',
            'description' => 'Soft organic cotton with custom hand-drawn illustrations.'
        ]);

        $catParaniu = \App\Models\Category::where('slug', 'paraniu')->first();
        \App\Models\Gallery::updateOrCreate(['title' => 'Sample Paraniu'], [
            'category_id' => $catParaniu->id,
            'image_path' => 'assets/paraniu.png',
            'badge' => 'New Arrival',
            'description' => 'Decorative cradle cloths for a beautiful sleep environment.'
        ]);

        $catGodadi = \App\Models\Category::where('slug', 'godadi')->first();
        \App\Models\Gallery::updateOrCreate(['title' => 'Sample Godadi'], [
            'category_id' => $catGodadi->id,
            'image_path' => 'assets/godadi.png',
            'badge' => 'Handmade',
            'description' => 'Comfortable and stylish handmade baby quilts.'
        ]);

        $catRumal = \App\Models\Category::where('slug', 'rumal')->first();
        \App\Models\Gallery::updateOrCreate(['title' => 'Sample Rumal'], [
            'category_id' => $catRumal->id,
            'image_path' => 'assets/rumal.png',
            'badge' => 'Traditional',
            'description' => 'Elegant ritual cloths for capturing those direct first steps.'
        ]);
    }
}
