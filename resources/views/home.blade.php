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
    <section class="section" id="arrivals" style="background: var(--bg-dark);">
        <div class="container text-center">
            <span class="text-primary fw-bold text-uppercase ls-3 small">Exclusive</span>
            <h2 class="section-title mt-2">New Arrivals</h2>
            <p class="section-desc mt-3 mx-auto">
                Our latest handmade masterpieces, carefully selected for you.
            </p>
            
            <div class="row g-4 mt-5 justify-content-center">
                @forelse($galleryItems as $item)
                    <div class="col-lg-3 col-md-6">
                        <a href="{{ route('gallery.show', $item->slug) }}" class="card" style="text-decoration: none; color: inherit; display: block;">
                            @if($item->badge)
                                <span class="card-badge">{{ $item->badge }}</span>
                            @endif
                            <div class="card-img-wrapper">
                                @if($item->primaryImage)
                                    <img src="{{ asset($item->primaryImage->image_path) }}" alt="{{ $item->title }} - Hand-painted Art by VastraKala" class="card-img w-100" loading="lazy">
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
    <section class="section" id="inquiry" style="background: var(--surface-accent);">
        <div class="container py-lg-4">
            <div class="row align-items-center gx-lg-5 gy-5">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="pe-lg-5">
                        <span class="text-primary fw-bold text-uppercase ls-3 small">Connect With Us</span>
                        <h2 class="section-title text-start mt-2 text-primary" style="font-family: var(--font-heading);">Custom Art Inquiry</h2>
                        <p class="section-desc text-start mt-3 ms-0 mb-5" style="font-size: 1.15rem; color: var(--text-light);">
                            Have a specific design in mind? Or need help choosing the perfect handmade artwork for your special occasion? Send us an inquiry, and we'll chat with you directly on WhatsApp.
                        </p>
                        
                        <div class="d-flex align-items-start mb-5">
                            <div class="icon-circle bg-primary-light text-primary me-4 flex-shrink-0" style="width: 60px; height: 60px; font-size: 1.5rem;">
                                <i class="fa-solid fa-paintbrush"></i>
                            </div>
                            <div>
                                <h4 class="h5 mb-2 fw-bold" style="color: var(--text-dark);">Exquisite Hand-Painting</h4>
                                <p class="mb-0" style="color: var(--text-light);">Each artwork is hand-painted with professional precision to match your specific style and vision.</p>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-start">
                            <div class="icon-circle bg-primary-light text-primary me-4 flex-shrink-0" style="width: 60px; height: 60px; font-size: 1.5rem;">
                                <i class="fa-brands fa-whatsapp"></i>
                            </div>
                            <div>
                                <h4 class="h5 mb-2 fw-bold" style="color: var(--text-dark);">Instant Chat</h4>
                                <p class="mb-0" style="color: var(--text-light);">Get answers to your questions instantly through our dedicated WhatsApp support line.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="inquiry-card p-3 p-md-5 p-lg-5 rounded-5 shadow-soft border border-light-subtle background-white position-relative overflow-hidden">
                        <h3 class="mb-4 position-relative text-primary" style="font-family: var(--font-heading);">Send an Inquiry</h3>
                        <form id="whatsappInquiryForm" class="position-relative">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label for="inquiry_name" class="form-label ms-2 small fw-bold text-uppercase" style="color: var(--text-light);">Your Name</label>
                                        <input type="text" class="form-control rounded-4 py-3" name="name" id="inquiry_name" placeholder="Full name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label for="inquiry_phone" class="form-label ms-2 small fw-bold text-uppercase" style="color: var(--text-light);">Phone Number</label>
                                        <input type="tel" class="form-control rounded-4 py-3" name="phone" id="inquiry_phone" placeholder="Mobile number" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label for="inquiry_product" class="form-label ms-2 small fw-bold text-uppercase" style="color: var(--text-light);">Product or Theme</label>
                                <input type="text" class="form-control rounded-4 py-3" name="product" id="inquiry_product" placeholder="What are you looking for?">
                            </div>
                            <div class="form-group mb-4">
                                <label for="inquiry_message" class="form-label ms-2 small fw-bold text-uppercase" style="color: var(--text-light);">Message Details</label>
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
                <span class="text-primary fw-bold text-uppercase ls-3 small">Kind Words</span>
                <h2 class="section-title mt-2">What Customers Say</h2>
            </div>

            @if($testimonials->isNotEmpty())
            <!-- Testimonials Carousel -->
            <div class="swiper testimonial-swiper pb-5">
                <div class="swiper-wrapper">
                    @foreach($testimonials as $testimonial)
                        <div class="swiper-slide h-auto">
                            <div class="testimonial-card">
                                <span class="testimonial-quote" style="color: var(--accent-main)!important;">“</span>
                                <div>
                                    <div class="star-rating" style="color: #FFB30E;">
                                        @for($i=0; $i<$testimonial->rating; $i++)
                                        <i class="fa-solid fa-star"></i>
                                        @endfor
                                    </div>
                                    <p class="testimonial-content" style="color: var(--text-header);">
                                        {{ $testimonial->content }}
                                    </p>
                                </div>
                                
                                <div class="testimonial-author mt-4 pt-3" style="color: var(--text-header);">
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

            <div class="text-center mt-5">
                <a href="{{ route('reviews.create') }}" class="btn btn-outline-primary rounded-pill px-5 py-3 fw-bold">
                    Share Your Own Experience <i class="fa-solid fa-pen-nib ms-2"></i>
                </a>
            </div>

            @else
                <div class="text-center py-5">
                    <div class="mb-4 d-flex justify-content-center">
                        <div class="icon-circle bg-white text-primary" style="width: 80px; height: 80px; font-size: 2rem; box-shadow: var(--shadow-soft);">
                            <i class="fa-solid fa-quote-left"></i>
                        </div>
                    </div>
                    <h3 class="h4 mb-2" style="font-family: var(--font-heading);">No Reviews Yet</h3>
                    <p class="text-muted mx-auto" style="max-width: 500px;">
                        Be the first to share your experience with our handcrafted masterpieces!
                    </p>
                    <div class="mt-4">
                        <a href="{{ route('reviews.create') }}" class="btn btn-primary rounded-pill px-5 fw-bold">Write a Review</a>
                    </div>
                </div>
            @endif
        </div>
    </section>

    @if(($settings['show_referral'] ?? '1') == '1')
    <!-- Referral & Earn Section -->
    <section class="section" id="refer" style="background: var(--surface-accent); padding: 5rem 0;">
        <div class="container">
            <div class="referral-container p-4 p-md-5 rounded-5 shadow-lg border-0 position-relative overflow-hidden" 
                 style="background: linear-gradient(135deg, #7E6258 0%, #a67c52 100%); color: white;">
                
                <!-- Decorative Icon -->
                <div class="position-absolute" style="top: -20px; right: -20px; opacity: 0.1; font-size: 15rem;">
                    <i class="fa-solid fa-gift"></i>
                </div>

                <div class="row align-items-center position-relative gx-lg-5 gy-4">
                    <div class="col-lg-7">
                        <div class="pe-lg-4">
                            <span class="badge bg-white text-primary px-3 py-2 rounded-pill fw-bold text-uppercase mb-3 ls-1">Spread the Word</span>
                            <h2 class="display-6 fw-bold mb-3" style="font-family: var(--font-heading);">Refer 10 Friends & Unlock a Special Surprise!</h2>
                            <p class="lead mb-4 opacity-75">
                                Share your unique link with friends. Once 10 people join using your link, you'll unlock a special reward!
                            </p>

                            <div class="referral-progress-container mb-5">
                                <div class="d-flex justify-content-between mb-2 flex-wrap gap-2">
                                    <span class="fw-bold fs-6">Your Progress</span>
                                    <span class="fw-bold fs-6 text-white">{{ $myReferralCount }} / {{ $myReferral->target_count ?? 10 }} Friends Joined</span>
                                </div>
                                <div class="progress rounded-pill bg-white bg-opacity-25 shadow-sm" style="height: 14px;">
                                    <div class="progress-bar bg-white rounded-pill shadow-sm" role="progressbar" 
                                         style="width: {{ min(100, (($myReferralCount ?? 0) / ($myReferral->target_count ?? 10)) * 100) }}%" 
                                         aria-valuenow="{{ $myReferralCount ?? 0 }}" aria-valuemin="0" aria-valuemax="{{ $myReferral->target_count ?? 10 }}"></div>
                                </div>
                            </div>

                            @if($myReferral && $myReferral->is_completed)
                                <div class="alert alert-light bg-white bg-opacity-10 text-white p-3 p-md-4 rounded-4 border border-white border-opacity-25 d-flex align-items-center mb-5 animate__animated animate__fadeIn">
                                    <div class="icon-circle bg-white text-primary me-3 flex-shrink-0" style="width: 45px; height: 45px;">
                                        <i class="fa-solid fa-trophy" style="font-size: 1.3rem;"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="mb-1 fw-bold small">Goal Reached! Congratulations! 🎉</h5>
                                        @if($myReferral->is_used)
                                            <p class="mb-0 x-small opacity-90">
                                                Already Used.
                                            </p>
                                        @else
                                            <p class="mb-0 x-small opacity-90 d-flex align-items-center flex-wrap gap-2">
                                                Prize code: 
                                                <span class="d-inline-flex align-items-center bg-white text-primary px-2 py-1 rounded fw-bold" style="cursor: pointer;" onclick="copyRewardCode(event, '{{ $myReferral->reward_code }}')">
                                                    {{ $myReferral->reward_code }}
                                                    <i class="fa-solid fa-copy ms-2" style="font-size: 0.7rem; opacity: 0.7;"></i>
                                                </span>
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <div class="d-flex flex-column flex-md-row gap-3 mt-4">
                                <button onclick="copyReferralLink(event)" class="btn btn-light rounded-pill px-4 py-3 fw-bold shadow-sm d-flex align-items-center justify-content-center transition-all">
                                    <i class="fa-solid fa-copy me-2"></i> Copy My Link
                                </button>
                                <a href="https://wa.me/?text={{ urlencode('Check out these amazing handmade masterpieces at Vastrakala! ' . ($myReferral ? route('home', ['via' => $myReferral->referral_code]) : route('home'))) }}" 
                                   target="_blank" class="btn btn-success border-0 rounded-pill px-4 py-3 fw-bold shadow-sm d-flex align-items-center justify-content-center" style="background-color: #25D366;">
                                    <i class="fa-brands fa-whatsapp me-2"></i> Share on WhatsApp
                                </a>
                            </div>
                            <input type="text" id="referralUrlInput" class="visually-hidden" readonly value="{{ $myReferral ? route('home', ['via' => $myReferral->referral_code]) : route('home') }}">
                        </div>
                    </div>
                    
                    <div class="col-lg-5 text-center mt-4 mt-lg-0">
                        <div class="p-4 p-md-5 bg-white bg-opacity-10 rounded-5 border border-white border-opacity-20 backdrop-blur d-flex flex-column align-items-center justify-content-center h-100">
                            <div class="mb-4">
                                <div class="icon-circle bg-white text-primary mx-auto shadow-lg" style="width: 90px; height: 90px; font-size: 2.5rem;">
                                    <i class="fa-solid fa-gift"></i>
                                </div>
                            </div>
                            <h3 class="fw-bold mb-3 text-white h4">Unlock Your Reward</h3>
                            <p class="opacity-75 mb-0 text-white" style="font-size: 1rem;">
                                Every unique visitor counts towards your goal. <br class="d-none d-md-block">Start sharing with your groups now!
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

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
        border: 1px solid var(--glass-border);
        background-color: var(--bg-cream);
        color: var(--text-dark);
        transition: all 0.3s ease;
    }
    
    .inquiry-card .form-control:focus {
        background-color: var(--white);
        border-color: var(--primary);
        box-shadow: 0 0 0 0.25rem var(--primary-light);
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

    function copyReferralLink(event) {
        const copyText = document.getElementById("referralUrlInput");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        
        try {
            // Modern method
            navigator.clipboard.writeText(copyText.value);
        } catch (err) {
            // Fallback for older browsers
            document.execCommand("copy");
        }
        
        const btn = event.currentTarget;
        const originalHtml = btn.innerHTML;
        btn.innerHTML = '<i class="fa-solid fa-check me-2"></i> Copied!';
        btn.classList.replace('btn-light', 'btn-white');
        setTimeout(() => {
            btn.innerHTML = originalHtml;
            btn.classList.replace('btn-white', 'btn-light');
        }, 2000);
    }

    function copyRewardCode(event, code) {
        if (!code) return;
        
        try {
            navigator.clipboard.writeText(code);
        } catch (err) {
            const temp = document.createElement("input");
            document.body.appendChild(temp);
            temp.value = code;
            temp.select();
            document.execCommand("copy");
            document.body.removeChild(temp);
        }
        
        const span = event.currentTarget;
        const originalContent = span.innerHTML;
        
        span.innerHTML = 'Copied! <i class="fa-solid fa-check ms-1"></i>';
        span.classList.replace('text-primary', 'text-success');
        
        setTimeout(() => {
            span.innerHTML = originalContent;
            span.classList.replace('text-success', 'text-primary');
        }, 2000);
    }
</script>
@endsection
