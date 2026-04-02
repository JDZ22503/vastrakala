<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Little Baby Creations') }}</title>

        <!-- Fonts (Same as website) -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap"
            rel="stylesheet"
        />

        <!-- Scripts (Vite removed) -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <script src="{{ asset('js/app.js') }}" defer></script>

        <style>
            :root {
                --primary: #D1A392;
                --bg-cream: #FCF8F3;
            }
            body { font-family: 'Outfit', sans-serif !important; }
            .bg-blush-cream { background-color: var(--bg-cream) !important; }
            .btn-primary-custom {
                background-color: var(--primary) !important;
                color: white !important;
                border-radius: 50px !important;
                padding: 0.8rem 2rem !important;
                box-shadow: 0 10px 20px rgba(209, 163, 146, 0.3) !important;
                transition: transform 0.3s ease !important;
            }
            .btn-primary-custom:hover { transform: translateY(-3px); }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-blush-cream">
            <div class="mb-8">
                <a href="/">
                    <x-application-logo />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-10 py-10 bg-white shadow-md overflow-hidden sm:rounded-[40px] border border-gray-50">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
