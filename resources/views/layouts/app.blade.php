<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Vastralkala Admin') }}</title>
        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap"
            rel="stylesheet"
        />

        <!-- Icons -->
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        />

        <!-- Scripts (Vite removed) -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <script src="{{ asset('js/app.js') }}" type="module" defer></script>
        
        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
        <style>
            :root {
                --primary: #D1A392;
                --primary-dark: #7E635A;
                --bg-cream: #FCF8F3;
                --white: #FFFFFF;
                --white-80: rgba(255, 255, 255, 0.8);
                --white-60: rgba(255, 255, 255, 0.6);
                --border-soft: rgba(209, 163, 146, 0.2);
                --text-dark: #4A3F35;
                --text-light: #7E635A;
            }
            body { 
                font-family: 'Outfit', sans-serif !important; 
                background-color: var(--bg-cream);
                color: var(--text-dark);
            }
            .bg-blush-cream { background-color: var(--bg-cream) !important; }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen">
            @include('layouts.navigation')
 
            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow-sm border-b" style="border-color: var(--border-soft);">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <h2 class="font-semibold text-xl leading-tight" style="font-family: 'Playfair Display', serif; color: var(--primary-dark);">
                            {{ $header }}
                        </h2>
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

            @stack('scripts')
        </div>
    </body>
</html>
