<!-- Footer -->
<footer id="contact">
    <div class="container">
        <h2 class="section-title mb-2">{{ config('app.name', 'Vastraकला ') }}</h2>
        @php
               $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
        @endphp
        <!-- Address Section -->
        <p class="address mb-4" style="color: var(--text-light); font-size: 0.95rem;">
            <i class="fa-solid fa-location-dot me-2 text-primary"></i> 
            {{ $settings['address'] ?? 'Shop No. 5, Silver Plaza, Near Main Market, Surat, Gujarat' }}
        </p>

        <div class="social-links">
            <a href="https://wa.me/{{ $settings['whatsapp'] ?? '910000000000' }}" target="_blank" title="WhatsApp Me">
                <i class="fa-brands fa-whatsapp"></i>
            </a>
            
            <a href="tel:{{ $settings['phone'] ?? '+910000000000' }}" title="Call Me">
                <i class="fa-solid fa-phone"></i>
            </a>
            
            <a href="{{ $settings['instagram'] ?? 'https://instagram.com' }}" target="_blank" title="Instagram">
                <i class="fa-brands fa-instagram"></i>
            </a>
        </div>
        <p class="copyright">&copy; {{ date('Y') }} {{ config('app.name', 'Vastraकला ') }}. | Hand-Painted with Love <i class="fa-solid fa-heart text-[#D1A392]"></i></p>
    </div>
</footer>
