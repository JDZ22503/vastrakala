@extends('layouts.public')

@section('title', $item->title)

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
    .detail-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 5rem;
        align-items: start;
    }
    .detail-image-gallery {
        position: sticky;
        top: 8rem;
        width: 100%;
        overflow: hidden;
    }
    .swiper-main {
        width: 100%;
        aspect-ratio: 3/4;
        border-radius: 40px;
        box-shadow: var(--shadow-soft);
        border: 8px solid var(--surface-card);
        background: var(--surface-card);
    }
    .swiper-main img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .swiper-thumbs {
        margin-top: 1.5rem;
        box-sizing: border-box;
        padding: 5px 0;
    }
    .swiper-thumbs .swiper-slide {
        width: 25%;
        height: 100%;
        opacity: 0.4;
        cursor: pointer;
        transition: var(--transition);
    }
    .swiper-thumbs .swiper-slide-thumb-active {
        opacity: 1;
    }
    .thumb-img {
        width: 100%;
        aspect-ratio: 1/1;
        object-fit: cover;
        border-radius: 15px;
        border: 3px solid var(--surface-card);
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
    .swiper-thumbs .swiper-slide-thumb-active .thumb-img {
        border-color: var(--primary);
    }
    .detail-info {
        padding-top: 2rem;
    }
    .detail-category {
        color: var(--primary);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 0.9rem;
        margin-bottom: 1rem;
        display: block;
    }
    .detail-title {
        font-size: clamp(2.5rem, 5vw, 4rem);
        line-height: 1.1;
        margin-bottom: 2rem;
    }
    .detail-badge {
        display: inline-block;
        background: var(--primary-light);
        color: var(--primary);
        padding: 0.5rem 1.2rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.8rem;
        margin-bottom: 2rem;
    }
    .detail-desc {
        font-size: 1.2rem;
        line-height: 1.8;
        color: var(--text-light);
        margin-bottom: 3rem;
    }
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--text-dark);
        font-weight: 600;
        margin-bottom: 2rem;
        transition: var(--transition);
    }
    .back-link:hover {
        color: var(--primary);
        transform: translateX(-5px);
    }

    @media (max-width: 992px) {
        .detail-container {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        .detail-image-gallery {
            position: relative;
            top: 0;
        }
        .detail-page-section {
            padding-top: 3.5rem !important;
        }
    }
    .detail-page-section {
        padding-top: 10rem;
    }
</style>
@endsection

@section('content')
<section class="section detail-page-section">
    <div class="container mt-5 mt-sm-10">
        <a href="{{ route('gallery') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to Gallery
        </a>

        <div class="detail-container">
            <div class="detail-image-gallery">
                @if($item->images->count() > 0)
                    <!-- Main Slider -->
                    <div class="swiper swiper-main">
                        <div class="swiper-wrapper">
                            @foreach($item->images as $photo)
                                <div class="swiper-slide">
                                    <img src="{{ asset($photo->image_path) }}" alt="{{ $item->title }} - Original Handmade Design by VastraKala" loading="lazy" />
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Thumbs Slider -->
                    @if($item->images->count() > 1)
                        <div class="swiper swiper-thumbs">
                            <div class="swiper-wrapper">
                                @foreach($item->images as $photo)
                                    <div class="swiper-slide">
                                        <img src="{{ asset($photo->image_path) }}" alt="{{ $item->title }} Thumb" class="thumb-img" loading="lazy" />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @else
                    <div class="swiper-main flex items-center justify-center p-20 text-gray-400">No photos available</div>
                @endif
            </div>

            <div class="detail-info">
                <span class="detail-category">{{ $item->category->name }}</span>
                <h1 class="detail-title">{{ $item->title }}</h1>
                
                @if($item->badge)
                    <span class="detail-badge">{{ $item->badge }}</span>
                @endif

                <div class="detail-desc">
                    {!! $item->description !!}
                </div>

                @php
                    $whatsappNumber = preg_replace('/[^0-9]/', '', $settings['whatsapp'] ?? '919510168399');
                    $message = "Hello Vastraकला! 🎨\n\nI'm interested in booking a custom order for this design:\n\n*📌 Design:* {$item->title}\n*📁 Category:* {$item->category->name}\n*🔗 View Here:* " . url()->current();
                    $whatsappUrl = "https://wa.me/{$whatsappNumber}?text=" . urlencode($message);
                @endphp

                <div style="background: var(--bg-cream); padding: 2rem; border-radius: 30px; border: 1px dashed var(--primary);">
                    <h4 style="margin-bottom: 0.5rem; color: var(--primary);">Interested in this design?</h4>
                    <p style="font-size: 0.9rem; margin-bottom: 1.5rem; color: var(--text-light);">Every piece is unique and can be customized with your choice of colors and names.</p>
                    <a href="{{ $whatsappUrl }}" target="_blank" class="btn-primary" style="display: block; text-align: center; text-decoration: none;">
                        <i class="fa-brands fa-whatsapp me-2"></i> Book via WhatsApp Now
                    </a>
                </div>
            </div>
        </div>

        @if($item->artisan_note)
        <!-- Item 6: Behind the Craft (Storytelling) -->
        <div class="behind-the-craft-section" style="margin-top: 8rem; position: relative; background: var(--surface-card); border-radius: 60px; box-shadow: var(--shadow-soft); border: 1px solid var(--glass-border); overflow: hidden;">
            <!-- Responsive Padding Wrapper -->
            <div class="p-4 p-md-5 py-md-10" style="position: relative; z-index: 1;">
                <div class="decorative-icon d-none d-md-block" style="position: absolute; top: -50px; right: -50px; font-size: 20rem; color: var(--accent-main); z-index: -1; font-family: 'Playfair Display', serif; transform: rotate(-10deg); opacity: 0.05; pointer-events: none;">
                    <i class="fa-solid fa-feather-pointed"></i>
                </div>
            
                <div style="position: relative; z-index: 1; max-width: 900px; margin: 0 auto; text-align: center;">
                    <span class="ls-3" style="font-family: var(--font-body); text-transform: uppercase; color: var(--accent-gold); font-weight: 800; font-size: 0.75rem; display: block; margin-bottom: 1.5rem;">The Soul of the Art</span>
                    <h2 style="font-family: var(--font-heading); font-size: clamp(2.5rem, 5vw, 4rem); color: var(--text-header); margin-bottom: 3rem; line-height: 1.1;">Behind the Artistry</h2>
                    
                    <div class="artisan-story-content" style="font-size: clamp(1.2rem, 3vw, 1.6rem); line-height: 1.9; color: var(--text-header); font-family: var(--font-heading); font-style: italic; opacity: 0.95;">
                        <i class="fa-solid fa-quote-left" style="color: var(--accent-gold); margin-bottom: 2rem; display: block; font-size: 2.5rem;"></i>
                        {!! $item->artisan_note !!}
                    </div>
                    
                    <div style="margin-top: 4rem; display: flex; align-items: center; justify-content: center; gap: 1.5rem;">
                        <div style="width: 60px; height: 1px; background: var(--accent-gold); opacity: 0.5;"></div>
                        <span style="font-family: var(--font-body); font-weight: 800; color: var(--accent-main); text-transform: uppercase; letter-spacing: 3px; font-size: 0.7rem;">Artisan's Personal Note</span>
                        <div style="width: 60px; height: 1px; background: var(--accent-gold); opacity: 0.5;"></div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Item 8: Shop the Look / Related Pieces -->
        @if($relatedItems->count() > 0)
        <div class="related-pieces-section" style="margin-top: 10rem; margin-bottom: 5rem;">
            <div style="text-align: center; margin-bottom: 4rem;">
                <h3 style="font-family: var(--font-heading); font-size: 2.8rem; color: var(--text-header);">Related Masterpieces</h3>
                <div style="width: 50px; height: 3px; background: var(--accent-gold); margin: 15px auto;"></div>
            </div>

            <div class="row g-4 justify-content-center">
                @foreach($relatedItems as $related)
                <div class="col-6 col-md-3">
                    <div class="related-card" style="background: var(--surface-card); border-radius: 30px; padding: 1.2rem; box-shadow: var(--shadow-soft); border: 1px solid var(--glass-border); transition: var(--transition); height: 100%;">
                        <a href="{{ route('gallery.show', $related->slug) }}" style="text-decoration: none; color: inherit;">
                            <div style="aspect-ratio: 3/4; border-radius: 20px; overflow: hidden; margin-bottom: 1.2rem; background: var(--surface-main);">
                                @if($related->primaryImage)
                                    <img src="{{ asset($related->primaryImage->image_path) }}" 
                                         alt="{{ $related->title }} - More from VastraKala" 
                                         style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;"
                                         onmouseover="this.style.transform='scale(1.1)'"
                                         onmouseout="this.style.transform='scale(1)'"
                                         loading="lazy">
                                @endif
                            </div>
                            <span style="font-size: 0.65rem; color: var(--accent-gold); font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; display: block; margin-bottom: 0.3rem;">{{ $related->category->name }}</span>
                            <h5 style="font-family: var(--font-heading); font-size: 1rem; color: var(--text-header); margin-bottom: 0;">{{ $related->title }}</h5>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const thumbCount = {{ $item->images->count() }};
        
        // Initialize Thumbs
        const swiperThumbs = new Swiper(".swiper-thumbs", {
            spaceBetween: 15,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesProgress: true,
            // Only enable sliding if more than 4 images
            allowTouchMove: thumbCount > 4,
            breakpoints: {
                0: { slidesPerView: 3, spaceBetween: 10 },
                576: { slidesPerView: 4, spaceBetween: 15 }
            }
        });

        // Initialize Main
        const swiperMain = new Swiper(".swiper-main", {
            spaceBetween: 10,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            thumbs: {
                swiper: swiperThumbs,
            },
        });
    });
</script>
@endsection
@endsection
