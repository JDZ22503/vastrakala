<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>@yield('title') | {{ config('app.name', 'VastraKala') }}</title>
        <meta name="description" content="VastraKala - Hand-painted fabric art and creative designs by Ayush Zalavadiya. Unique, handcrafted designs on high-quality fabric." />
        <meta name="keywords" content="Vastrakala, hand-painted fabric, fabric art, Ayush Zalavadiya, creative design, unique clothing" />
        
        <!-- Canonical URL -->
        <link rel="canonical" href="{{ url()->current() }}" />
        
        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website" />
        <meta property="og:url" content="{{ url()->current() }}" />
        <meta property="og:title" content="VastraKala | Hand-Painted Fabric Art" />
        <meta property="og:description" content="Unique, hand-painted fabric designs by Ayush Zalavadiya. Every piece tells a story." />
        <meta property="og:image" content="{{ asset('images/logo.png') }}" />
        
        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap"
            rel="stylesheet"
        />

        <!-- Assets -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="{{ asset('js/main.js') }}" type="module" defer></script>
        {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script> --}}
            

        <!-- Icons -->
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        />
        
        <!-- Swiper.js -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
        
        <!-- Theme Detection (Flash-free) -->
        <script>
            (function() {
                const theme = localStorage.getItem('theme') || 'light';
                document.documentElement.setAttribute('data-theme', theme);
            })();
        </script>

        @yield('styles')
    </head>
    <body style="background-color: var(--bg-cream)">
        <!-- Navigation Overlay (Mobile) -->
        <div id="mobile-nav" class="mobile-nav-overlay">
            <div class="side-menu-header">
                <div class="side-logo-container">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="side-logo">
                </div>
                <div class="d-flex align-items-center gap-2">
                    <button class="theme-toggle-btn" onclick="toggleTheme()" aria-label="Toggle Dark Mode">
                        <i class="fa-solid fa-sun light-mode-icon"></i>
                        <i class="fa-solid fa-moon dark-mode-icon"></i>
                    </button>
                    <button id="mobile-menu-close"><i class="fa-solid fa-times"></i></button>
                </div>
            </div>
            <div class="mobile-nav-content">
                <a href="{{ route('home') }}" >Home</a>
                <a href="{{ route('gallery') }}">Gallery</a>
                <a href="{{ route('about') }}">About</a>
                <a href="{{ route('home') }}#inquiry">Inquiry</a>
                <a href="{{ route('contact') }}" class="mobile-cta-btn">Contact Us</a>
            </div>
        </div>

        <!-- Desktop Navigation -->
        <nav class="nav-transparent">
            <div class="nav-container">
                <a href="{{ route('home') }}" class="brand-name">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="main-logo">
                </a>

                <div class="nav-links d-none d-md-flex align-items-center">
                    <a href="{{ route('home') }}">Home</a>
                    <a href="{{ route('gallery') }}">Gallery</a>
                    <a href="{{ route('about') }}">About</a>
                    <a href="{{ route('home') }}#inquiry">Inquiry</a>
                    <button class="theme-toggle-btn mx-2" onclick="toggleTheme()" aria-label="Toggle Dark Mode">
                        <i class="fa-solid fa-sun light-mode-icon"></i>
                        <i class="fa-solid fa-moon dark-mode-icon"></i>
                    </button>
                    <a href="{{ route('contact') }}" class="btn btn-primary">Contact Us</a>
                </div>

                <!-- Mobile Menu Toggle -->
                <div class="d-md-none d-flex align-items-center gap-2">
                    <button class="theme-toggle-btn" onclick="toggleTheme()" aria-label="Toggle Dark Mode">
                        <i class="fa-solid fa-sun light-mode-icon"></i>
                        <i class="fa-solid fa-moon dark-mode-icon"></i>
                    </button>
                    <button id="mobile-menu-btn">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                </div>
            </div>
        </nav>

        <main>
            @yield('content')
        </main>

        @if(($settings['show_referral'] ?? '1') == '1')
        <!-- Item 7: Exit-Intent "Reward Catch" Modal -->
        <div class="modal fade" id="exitIntentModal" tabindex="-1" aria-hidden="true" style="backdrop-filter: blur(15px);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content overflow-hidden" style="border-radius: 40px; border: none; box-shadow: var(--shadow-hover); background: var(--surface-card);">
                    <div class="modal-body p-0">
                        <div class="row g-0">
                            <div class="col-12 p-8 text-center" style="background: var(--surface-card); padding: 4rem 3rem;">
                                <div class="mb-4" style="font-size: 3.5rem; color: var(--accent-main); opacity: 0.9;">
                                    <i class="fa-solid fa-gift"></i>
                                </div>
                                <h1 style="font-family: var(--font-heading); font-size: 2.2rem; color: var(--text-header); margin-bottom: 1.2rem; line-height: 1.2;">Wait! Don't go <br>empty-handed.</h1>
                                <p style="color: var(--text-body); font-size: 1.15rem; margin-bottom: 3rem; line-height: 1.6; opacity: 0.9;">
                                    Share your unique link now and get <strong style="color: var(--accent-main); font-weight: 800;">10% OFF</strong> your first order!
                                </p>
                                
                                <div class="d-grid gap-3">
                                    <a href="{{ route('home') }}#refer" class="btn btn-primary py-3 rounded-pill fw-bold text-lg" style="letter-spacing: 1px; font-family: var(--font-body);">
                                        Get My 10% Discount <i class="fa-solid fa-arrow-right ms-2"></i>
                                    </a>
                                    <button type="button" class="btn fw-bold border-0 bg-transparent hover:underline" data-bs-dismiss="modal" style="color: var(--text-muted); font-size: 0.9rem;">I'll pay full price instead</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @include('components.footer')
        
        <!-- Theme Management Script -->
        <script>
            function toggleTheme() {
                const currentTheme = document.documentElement.getAttribute('data-theme') || 'light';
                const newTheme = currentTheme === 'light' ? 'dark' : 'light';
                
                document.documentElement.setAttribute('data-theme', newTheme);
                localStorage.setItem('theme', newTheme);
            }

            // Sync with system theme changes (if no manual preference)
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                const savedTheme = localStorage.getItem('theme');
                if (!savedTheme) {
                    const newTheme = e.matches ? 'dark' : 'light';
                    document.documentElement.setAttribute('data-theme', newTheme);
                }
            });
        </script>

        <!-- jQuery and Validation -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
        <!-- Swiper JS -->
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            /* Item 7: Exit-Intent Logic (Desktop + Mobile Fallback) */
            $(document).ready(function() {
                @if(($settings['show_referral'] ?? '1') == '1')
                const now = new Date().getTime();
                const lastShown = localStorage.getItem('exit_intent_last_shown');
                const dayInMs = 24 * 60 * 60 * 1000;
                
                // Show if never shown OR shown more than 24 hours ago
                if (!lastShown || (now - lastShown) > dayInMs) {
                    
                    // 1. Desktop: Mouse Leave (Exit-Intent)
                    $(document).on('mouseleave', function(e) {
                        if (e.clientY < 20) {
                            showExitModal();
                        }
                    });

                    // 2. Mobile Fallback: Scroll Depth (70%)
                    $(window).on('scroll', function() {
                        const scrollPercent = ($(window).scrollTop() / ($(document).height() - $(window).height())) * 100;
                        if (scrollPercent > 70) {
                            showExitModal();
                        }
                    });

                    function showExitModal() {
                        const modalEl = document.getElementById('exitIntentModal');
                        if (modalEl && !localStorage.getItem('exit_intent_active')) {
                            const modal = new bootstrap.Modal(modalEl);
                            modal.show();
                            // Mark as active for this session AND store timestamp for 24h cooling
                            localStorage.setItem('exit_intent_active', 'true');
                            localStorage.setItem('exit_intent_last_shown', new Date().getTime());
                        }
                    }
                }
                @endif
            });
        </script>
        
        <style>
            #order-form label.error {
                color: #dc3545;
                font-size: 0.85rem;
                margin-top: 10px;
                font-weight: 500;
            }
            .form-control.error {
                border-color: #dc3545 !important;
                background-color: #fff8f8 !important;
            }
        </style>

        @yield('scripts')
    </body>
</html>
