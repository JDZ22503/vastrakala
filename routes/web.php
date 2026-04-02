<?php

use App\Http\Controllers\Admin\GalleryManagerController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');
Route::get('/gallery/{slug}', [GalleryController::class, 'show'])->name('gallery.show');
Route::get('/about', function () { return view('about'); })->name('about');
Route::get('/contact', function () { return view('contact'); })->name('contact');

// Admin Routes Prefix: /ayush-admin (Protected by auth)
Route::middleware('auth')->prefix('ayush-admin')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/', function() {
        return redirect()->route('dashboard');
    });

    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');

    // Gallery Management (Insert Data)
    Route::get('/gallery/create', [GalleryManagerController::class, 'create'])->name('admin.gallery.create');
    Route::post('/gallery/store', [GalleryManagerController::class, 'store'])->name('admin.gallery.store');
    Route::get('/gallery/list', [GalleryManagerController::class, 'index'])->name('admin.gallery.index');
    Route::post('/gallery/{gallery}/toggle-new-arrival', [GalleryManagerController::class, 'toggleNewArrival'])->name('admin.gallery.toggle_new_arrival');
    Route::delete('/gallery/photo/{photo}', [GalleryManagerController::class, 'deletePhoto'])->name('gallery.photo.delete');
    Route::post('/gallery/reorder-photos', [GalleryManagerController::class, 'reorderPhotos'])->name('gallery.photos.reorder');
    Route::get('/gallery/{gallery}/edit', [GalleryManagerController::class, 'edit'])->name('admin.gallery.edit');
    Route::put('/gallery/{gallery}', [GalleryManagerController::class, 'update'])->name('admin.gallery.update');
    Route::delete('/gallery/{gallery}', [GalleryManagerController::class, 'destroy'])->name('admin.gallery.destroy');

    // Category Management
    Route::get('/categories', [\App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('admin.categories.index');
    Route::post('/categories', [\App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('admin.categories.store');
    Route::patch('/categories/{category}', [\App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('/categories/{category}', [\App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('admin.categories.destroy');
    // Testimonial Management
    Route::resource('testimonials', \App\Http\Controllers\Admin\TestimonialController::class)->names('admin.testimonials');
    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth Routes (Login, Register, etc.)
Route::prefix('ayush-admin')->group(function () {
    require __DIR__.'/auth.php';
});
