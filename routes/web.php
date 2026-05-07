<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleryManagerController;
use App\Http\Controllers\Admin\MockupController;
use App\Http\Controllers\Admin\ReferralController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MainPortfolioController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\PublicTestimonialController;
use Illuminate\Support\Facades\Route;

// --- VASTRAKALA SUBDOMAIN ROUTES ---
Route::domain('vastrakala.ayushzalavadiya.me')->group(function () {
// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');
Route::get('/gallery/{slug}', [GalleryController::class, 'show'])->name('gallery.show');
Route::get('/about', function () {
    return view('about');
})->name('about');
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Review Routes (Now part of Testimonials)
Route::get('/reviews/create', [PublicTestimonialController::class, 'create'])->name('reviews.create');
Route::post('/reviews', [PublicTestimonialController::class, 'store'])->name('reviews.store');

// Admin Routes Prefix: /ayush-admin (Protected by auth)
Route::middleware('auth')->prefix('ayush-admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/', function () {
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
    Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::patch('/categories/{category}', [CategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');
    // Testimonial Management
    Route::resource('testimonials', TestimonialController::class)->names('admin.testimonials');
    Route::post('/testimonials/{testimonial}/toggle-approval', [TestimonialController::class, 'toggleApproval'])->name('admin.testimonials.toggle_approval');
    
    // Profile Management
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

    // Referral Management
    Route::get('/referrals', [App\Http\Controllers\Admin\ReferralController::class, 'index'])->name('admin.referrals.index');
    Route::post('/referrals/{sharer}/toggle-used', [App\Http\Controllers\Admin\ReferralController::class, 'toggleUsed'])->name('admin.referrals.toggle_used');
    Route::patch('/referrals/{sharer}/update-note', [App\Http\Controllers\Admin\ReferralController::class, 'updateNote'])->name('admin.referrals.update_note');

    // Mockup Pro
    Route::get('/mockup-pro', [App\Http\Controllers\Admin\MockupController::class, 'index'])->name('admin.mockup_pro');
});

// Auth Routes (Login, Register, etc.)
Route::prefix('ayush-admin')->group(function () {
    require __DIR__.'/auth.php';
});
});

Route::domain('ayushzalavadiya.me')->group(function () {
    Route::get('/', [MainPortfolioController::class, 'index'])->name('portfolio');
    
    // Permanent Redirects for VastraKala content to the correct subdomain (SEO best practice)
    Route::get('/about', fn() => redirect()->to('https://vastrakala.ayushzalavadiya.me/about', 301));
    Route::get('/gallery', fn() => redirect()->to('https://vastrakala.ayushzalavadiya.me/gallery', 301));
    Route::get('/contact', fn() => redirect()->to('https://vastrakala.ayushzalavadiya.me/contact', 301));

    // Fallback: Redirect any other unknown routes on main domain to home
    Route::fallback(function () {
        return redirect()->route('portfolio');
    });
});
