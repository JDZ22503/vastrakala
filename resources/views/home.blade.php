@extends('layouts.public')

@section('title', 'Handmade Baby Products')

@section('content')
    <!-- Hero Section -->
    <header class="hero" id="home">
        <div class="container d-flex flex-column align-items-center pt-5">
            <span class="text-primary fw-bold text-uppercase ls-3 small">Artisanal Craftsmanship</span>
            <h1 class="hero-title mt-3">
                Artful <br /><span class="text-primary">Masterpieces</span>
            </h1>
            <p class="hero-subtitle mt-4 mx-auto" style="max-width: 600px;">
                Unique hand-painted artistry—customized with precision to turn your vision into a stunning reality.
            </p>
            <div class="hero-btns mt-5 d-flex gap-3 gap-md-4 justify-content-center">
                <a href="{{ route('gallery') }}" class="btn btn-primary px-4 px-md-5 py-3 rounded-pill fw-bold">Explore Gallery</a>
                <a href="{{ route('about') }}" class="btn btn-outline-primary rounded-pill px-4 px-md-5 py-3 fw-bold">About US</a>
            </div>
        </div>
    </header>

    <!-- Gallery Preview -->
    <section class="section" id="arrivals">
        <div class="container text-center">
            <span class="text-primary fw-bold text-uppercase ls-3 small">Exclusive</span>
            <h2 class="section-title mt-2">New Arrivals</h2>
            <p class="section-desc mt-3 mx-auto">
                Our latest handmade masterpieces, carefully selected for you.
            </p>
            
            <div class="row g-4 mt-5">
                @forelse($galleryItems as $item)
                    <div class="col-lg-3 col-md-6">
                        <a href="{{ route('gallery.show', $item->slug) }}" class="card" style="text-decoration: none; color: inherit; display: block;">
                            @if($item->badge)
                                <span class="card-badge">{{ $item->badge }}</span>
                            @endif
                            <div class="card-img-wrapper">
                                @if($item->primaryImage)
                                    <img src="{{ asset($item->primaryImage->image_path) }}" alt="{{ $item->title }}" class="card-img w-100">
                                @else
                                    <div class="card-img bg-light d-flex align-items-center justify-content-center p-5 text-muted">No Image</div>
                                @endif
                            </div>
                            <div class="card-content">
                                <h3>{{ $item->title }}</h3>
                                <p style="color: var(--text-light); font-size: 0.9rem;">
                                    {{ Str::limit($item->description, 80) }}
                                </p>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12 py-5 text-center text-muted">
                        No new arrivals found.
                    </div>
                @endforelse
            </div>

            <div class="mt-5 pt-4">
                <a href="{{ route('gallery') }}" class="btn btn-outline-primary rounded-pill px-5 py-3 fw-bold">
                    Explore All Designs
                </a>
            </div>
        </div>
    </section>


    <!-- Inquiry Section -->
    <section class="section bg-white" id="inquiry">
        <div class="container py-lg-4">
            <div class="row align-items-center gx-lg-5 gy-5">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="pe-lg-5">
                        <span class="text-primary fw-bold text-uppercase ls-3 small">Connect With Us</span>
                        <h2 class="section-title text-start mt-2">Custom Art Inquiry</h2>
                        <p class="section-desc text-start mt-3 ms-0 mb-5" style="font-size: 1.15rem;">
                            Have a specific design in mind? Or need help choosing the perfect handmade artwork for your special occasion? Send us an inquiry, and we'll chat with you directly on WhatsApp.
                        </p>
                        
                        <div class="d-flex align-items-start mb-5">
                            <div class="icon-circle bg-primary-light text-primary me-4 flex-shrink-0" style="width: 60px; height: 60px; font-size: 1.5rem;">
                                <i class="fa-solid fa-paintbrush"></i>
                            </div>
                            <div>
                                <h4 class="h5 mb-2 fw-bold">Exquisite Hand-Painting</h4>
                                <p class="text-muted mb-0">Each artwork is hand-painted with professional precision to match your specific style and vision.</p>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-start">
                            <div class="icon-circle bg-primary-light text-primary me-4 flex-shrink-0" style="width: 60px; height: 60px; font-size: 1.5rem;">
                                <i class="fa-brands fa-whatsapp"></i>
                            </div>
                            <div>
                                <h4 class="h5 mb-2 fw-bold">Instant Chat</h4>
                                <p class="text-muted mb-0">Get answers to your questions instantly through our dedicated WhatsApp support line.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="inquiry-card p-3 p-md-5 p-lg-5 rounded-5 shadow-soft border border-light-subtle bg-white position-relative overflow-hidden">
                        <h3 class="mb-4 position-relative" style="font-family: var(--font-heading);">Send an Inquiry</h3>
                        <form id="whatsappInquiryForm" class="position-relative">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label for="inquiry_name" class="form-label ms-2 small fw-bold text-uppercase text-muted">Your Name</label>
                                        <input type="text" class="form-control rounded-4 py-3" name="name" id="inquiry_name" placeholder="Full name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label for="inquiry_phone" class="form-label ms-2 small fw-bold text-uppercase text-muted">Phone Number</label>
                                        <input type="tel" class="form-control rounded-4 py-3" name="phone" id="inquiry_phone" placeholder="Mobile number" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label for="inquiry_product" class="form-label ms-2 small fw-bold text-uppercase text-muted">Product or Theme</label>
                                <input type="text" class="form-control rounded-4 py-3" name="product" id="inquiry_product" placeholder="What are you looking for?">
                            </div>
                            <div class="form-group mb-4">
                                <label for="inquiry_message" class="form-label ms-2 small fw-bold text-uppercase text-muted">Message Details</label>
                                <textarea class="form-control rounded-4 py-3" name="message" id="inquiry_message" rows="4" placeholder="Tell us more about your requirements..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold text-uppercase ls-1 shadow-sm mt-2">
                                Send Inquiry via WhatsApp <i class="fa-brands fa-whatsapp ms-2"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->

    <section class="testimonial-section" id="testimonials" style="background: var(--accent);">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title mt-2">What Customers Say</h2>
            </div>

            @if($testimonials->isNotEmpty())
            <!-- Testimonials Carousel -->
            <div class="swiper testimonial-swiper pb-5">
                <div class="swiper-wrapper">
                    @foreach($testimonials as $testimonial)
                        <div class="swiper-slide h-auto">
                            <div class="testimonial-card">
                                <span class="testimonial-quote text-dark">“</span>
                                <div>
                                    <div class="star-rating">
                                        @for($i=0; $i<$testimonial->rating; $i++)
                                        <i class="fa-solid fa-star text-dark"></i>
                                        @endfor
                                    </div>
                                    <p class="testimonial-content">
                                        {{ $testimonial->content }}
                                    </p>
                                </div>
                                
                                <div class="testimonial-author text-dark">
                                    @if($testimonial->avatar_path)
                                        <img src="{{ asset($testimonial->avatar_path) }}" alt="{{ $testimonial->customer_name }}" class="testimonial-avatar">
                                    @else
                                        <div class="testimonial-avatar-placeholder">
                                            {{ substr($testimonial->customer_name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div class="testimonial-info">
                                        <h5>{{ $testimonial->customer_name }}</h5>
                                        <p>{{ $testimonial->customer_designation }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Add Pagination -->
                <div class="swiper-pagination"></div>
            </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-4 d-flex justify-content-center">
                        <div class="icon-circle bg-white text-primary" style="width: 80px; height: 80px; font-size: 2rem; box-shadow: var(--shadow-soft);">
                            <i class="fa-solid fa-quote-left"></i>
                        </div>
                    </div>
                    <h3 class="h4 mb-2" style="font-family: var(--font-heading);">No Testimonials Yet</h3>
                    <p class="text-muted mx-auto" style="max-width: 500px;">
                        We're currently gathering feedback from our wonderful customers. 
                        Be the first to share your experience with our handcrafted masterpieces!
                    </p>
                    <div class="mt-4">
                        <a href="#inquiry" class="btn btn-primary rounded-pill px-5 fw-bold">Send an Inquiry</a>
                    </div>
                </div>
            @endif
        </div>
    </section>

@endsection

@section('styles')
<style>
    .icon-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }
    
    .bg-primary-light {
        background-color: var(--primary-light);
    }
    
    .inquiry-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .inquiry-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.08);
    }
    
    .inquiry-card .form-control {
        border: 1px solid rgba(0,0,0,0.05);
        background-color: #fcf8f3;
        transition: all 0.3s ease;
    }
    
    .inquiry-card .form-control:focus {
        background-color: #fff;
        border-color: var(--primary);
        box-shadow: 0 0 0 0.25rem rgba(126, 98, 88, 0.1);
    }
    
    .shadow-soft {
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
    }

    button.btn-primary:hover {
        background-color: var(--secondary) !important;
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(126, 98, 88, 0.2);
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $("#whatsappInquiryForm").validate({
            rules: {
                name: "required",
                phone: {
                    required: true,
                    minlength: 10,
                    digits: true
                },
                message: "required"
            },
            messages: {
                name: "Please enter your name",
                phone: {
                    required: "Please enter your phone number",
                    minlength: "Enter at least 10 digits",
                    digits: "Enter only digits"
                },
                message: "Please enter your message"
            },
            submitHandler: function(form) {
                const name = document.getElementById('inquiry_name').value;
                const phone = document.getElementById('inquiry_phone').value;
                const product = document.getElementById('inquiry_product').value;
                const message = document.getElementById('inquiry_message').value;
                
                @php
                    $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
                    $whatsappNumber = $settings['whatsapp'] ?? '910000000000';
                    $whatsappNumber = preg_replace('/[^0-9]/', '', $whatsappNumber);
                @endphp
                
                const phoneNumber = "{{ $whatsappNumber }}";
                
                let text = `*New Inquiry from Website*\n\n`;
                text += `*Name:* ${name}\n`;
                text += `*Phone:* ${phone}\n`;
                if (product) {
                    text += `*Interested In:* ${product}\n`;
                }
                text += `*Message:* ${message}`;
                
                const encodedText = encodeURIComponent(text);
                const whatsappUrl = `https://wa.me/${phoneNumber}?text=${encodedText}`;
                window.open(whatsappUrl, '_blank');
                return false;
            }
        });
    });
</script>
@endsection

