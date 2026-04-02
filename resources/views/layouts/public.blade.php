<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>@yield('title') | {{ config('app.name', 'Vastraकला ') }}</title>
        
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
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
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
        
        @yield('styles')
    </head>
    <body style="background-color: var(--bg-cream)">
        <!-- Navigation Overlay (Mobile) -->
        <div id="mobile-nav" class="mobile-nav-overlay">
            <div class="side-menu-header">
                <div class="side-logo-container">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="side-logo">
                </div>
                <button id="mobile-menu-close"><i class="fa-solid fa-times"></i></button>
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

                <div class="nav-links d-none d-md-flex">
                    <a href="{{ route('home') }}">Home</a>
                    <a href="{{ route('gallery') }}">Gallery</a>
                    <a href="{{ route('about') }}">About</a>
                    <a href="{{ route('home') }}#inquiry">Inquiry</a>
                    <a href="{{ route('contact') }}" class="btn btn-primary">Contact Us</a>
                </div>

                <!-- Mobile Menu Toggle -->
                <button id="mobile-menu-btn" class="d-md-none">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
        </nav>

        @yield('content')

        @include('components.footer')
        
        <!-- jQuery and Validation -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>

        <!-- Swiper.js -->
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        
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
