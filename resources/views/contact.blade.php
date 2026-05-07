@extends('layouts.public')

@section('title', 'Contact Us')

@section('styles')
<style>
    .contact-hero {
        padding: 9rem 0 7rem;
        background: var(--hero-overlay), url('{{ asset("images/bg1.png") }}');
        background-size: cover;
        background-position: center;
        text-align: center;
    }
    
    .contact-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
        margin-top: -3rem;
        position: relative;
        z-index: 10;
    }
    
    .contact-info-card {
        background: var(--surface-card);
        padding: 3.5rem;
        border-radius: 40px;
        box-shadow: var(--shadow-hover);
        height: 100%;
        display: flex;
        flex-direction: column;
        border: 1px solid var(--glass-border);
    }
    
    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }
    
    .info-icon {
        width: 60px;
        height: 60px;
        background: var(--surface-accent);
        color: var(--accent-main);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
        transition: var(--transition);
    }
    
    .info-item:hover .info-icon {
        background: var(--primary);
        color: white;
        transform: translateY(-5px);
    }
    
    .map-container {
        width: 100%;
        border-radius: 40px;
        overflow: hidden;
        box-shadow: var(--shadow-soft);
        margin-top: 5rem;
        border: 10px solid var(--surface-card);
    }
    
    @media (max-width: 992px) {
        .contact-grid {
            grid-template-columns: 1fr;
            margin-top: 0;
            padding-top: 2rem;
            gap: 2rem;
        }
        .contact-hero {
            padding: 8rem 2rem 4rem;
        }
    }
    
    @media (max-width: 768px) {
        .contact-info-card {
            padding: 2.5rem 1.5rem;
            border-radius: 30px;
        }
        .display-3 {
            font-size: 2.5rem;
        }
        .contact-grid {
            gap: 1.5rem;
        }
    }
    
    @media (max-width: 576px) {
        .info-item {
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 1rem;
        }
        .info-icon {
            width: 50px;
            height: 50px;
            font-size: 1.25rem;
        }
        .map-container {
            margin-top: 3rem;
            border-width: 5px;
            border-radius: 20px;
        }
        .map-container iframe {
            height: 350px;
        }
    }
</style>
@endsection

@section('content')
@php
    $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
@endphp

<!-- Contact Hero -->
<section class="contact-hero">
    <div class="container">
        <span class="text-primary fw-bold text-uppercase ls-3 small">Get in Touch</span>
        <h1 class="display-3 fw-bold mt-2" style="font-family: var(--font-heading);">Contact <span class="text-primary">Us</span></h1>
        <p class="mx-auto mt-3" style="max-width: 600px; color: var(--text-body);">
            We'd love to hear from you. Whether you have a question about our handmade artwork or want a custom painting in any theme, reach out to us!
        </p>
    </div>
</section>

<!-- Contact Info & Form -->
<section class="section pt-0">
    <div class="container">
        <div class="contact-grid">
            <!-- Contact Details -->
            <div class="contact-info-card">
                <h2 class="h3 mb-5" style="font-family: var(--font-heading);">Business Information</h2>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <div>
                        <h4 class="h6 text-uppercase fw-bold ls-1 mb-2" style="color: var(--text-muted);">Our Boutique</h4>
                        <p class="mb-0 fw-medium" style="color: var(--text-header);">
                            {{ $settings['address'] ?? 'Shop No. 5, Silver Plaza, Near Main Market, Surat, Gujarat' }}
                        </p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <div>
                        <h4 class="h6 text-uppercase fw-bold ls-1 mb-2" style="color: var(--text-muted);">Call Us</h4>
                        <p class="mb-0 fw-medium" style="color: var(--text-header);">
                            <a href="tel:{{ $settings['phone'] ?? '+910000000000' }}" class="text-decoration-none" style="color: var(--text-header);">
                                {{ $settings['phone'] ?? '+91 00000 00000' }}
                            </a>
                        </p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <div>
                        <h4 class="h6 text-uppercase fw-bold ls-1 mb-2" style="color: var(--text-muted);">WhatsApp</h4>
                        <p class="mb-0 fw-medium" style="color: var(--text-header);">
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['whatsapp'] ?? '910000000000') }}" target="_blank" class="text-decoration-none" style="color: var(--text-header);">
                                Chat with us directly
                            </a>
                        </p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <div>
                        <h4 class="h6 text-uppercase fw-bold ls-1 mb-2" style="color: var(--text-muted);">Email</h4>
                        <p class="mb-0 fw-medium" style="color: var(--text-header);">
                            <a href="mailto:{{ $settings['email'] ?? 'hello@vastrakala.com' }}" class="text-decoration-none" style="color: var(--text-header);">
                                {{ $settings['email'] ?? 'contact@vastrakala.com' }}
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Inquiry Form (Same as Homepage for consistency) -->
            <div class="contact-info-card">
                 <h2 class="h3 mb-5" style="font-family: var(--font-heading); color: var(--text-header);">Send a Message</h2>
                  <form id="whatsappInquiryForm2">
                    <div class="form-group mb-4">
                        <label class="form-label small fw-bold text-uppercase" style="color: var(--text-muted);">Your Name</label>
                        <input type="text" class="form-control rounded-4 py-3 border-0" name="name" id="c_name" placeholder="Full name" style="background: var(--surface-main); color: var(--text-header);" required>
                    </div>
                    <div class="form-group mb-4">
                        <label class="form-label small fw-bold text-uppercase" style="color: var(--text-muted);">Phone Number</label>
                        <input type="tel" class="form-control rounded-4 py-3 border-0" name="phone" id="c_phone" placeholder="Mobile number" style="background: var(--surface-main); color: var(--text-header);" required>
                    </div>
                    <div class="form-group mb-4">
                        <label class="form-label small fw-bold text-uppercase" style="color: var(--text-muted);">Message</label>
                        <textarea class="form-control rounded-4 py-3 border-0" name="message" id="c_message" rows="4" placeholder="How can we help?" style="background: var(--surface-main); color: var(--text-header);" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold text-uppercase ls-1 shadow-sm mt-2">
                        Send to WhatsApp <i class="fa-brands fa-whatsapp ms-2"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Google Map -->
        <div class="map-container">
            <iframe 
                src="https://www.google.com/maps?q=22.268311,70.816716&z=20&output=embed" 
                width="100%" 
                height="500" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $("#whatsappInquiryForm2").validate({
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
                const name = document.getElementById('c_name').value;
                const phone = document.getElementById('c_phone').value;
                const message = document.getElementById('c_message').value;
                
                @php
                    $whatsappNumber = $settings['whatsapp'] ?? '910000000000';
                    $whatsappNumber = preg_replace('/[^0-9]/', '', $whatsappNumber);
                @endphp
                
                const phoneNumber = "{{ $whatsappNumber }}";
                
                let text = `*New Inquiry from Contact Page*\n\n`;
                text += `*Name:* ${name}\n`;
                text += `*Phone:* ${phone}\n`;
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
