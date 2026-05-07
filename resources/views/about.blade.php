@extends('layouts.public')

@section('title', 'About Us')

@section('styles')
<style>
    .image-stack {
        position: relative;
        width: 100%;
        max-width: 500px;
        margin: 0 auto;
    }
    .image-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        aspect-ratio: 0.85;
        background-image: url('{{ asset("images/Picsart_25-12-01_23-33-21-981.jpg.jpeg") }}');
        background-size: cover;
        background-position: center;
        border-radius: 40px;
        transform: rotate(-10deg) scale(1.05);
        filter: sepia(1) opacity(0.2) blur(2px);
        z-index: 1;
    }
    .image-main {
        position: relative;
        width: 100%;
        aspect-ratio: 0.85;
        border-radius: 40px;
        overflow: hidden;
        box-shadow: var(--shadow-hover);
        z-index: 2;
        border: 10px solid var(--surface-card);
    }
    .image-main img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .about-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        align-items: center;
    }

    .about-title {
        font-family: 'Playfair Display', serif;
        font-size: clamp(2.2rem, 5vw, 4rem);
        margin: 1.5rem 0;
        line-height: 1.1;
    }

    .features-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }

    @media (max-width: 992px) {
        .about-grid {
            grid-template-columns: 1fr;
            gap: 3rem;
            text-align: center;
        }
        .about-content {
            padding: 0 1rem;
        }
        .section {
            padding-top: 9rem !important;
        }
    }

    @media (max-width: 576px) {
        .features-grid {
            grid-template-columns: 1fr;
        }
        .about-title {
            font-size: 2.2rem;
        }
        .image-bg {
            transform: rotate(-5deg) scale(1.02);
            border-radius: 30px;
        }
        .image-main {
            border-radius: 30px;
            border-width: 6px;
        }
    }
</style>
@endsection

@section('content')
<section class="section">
    <div class="container mt-5 mt-sm-10">
        <div class="about-grid">
            <div class="image-stack">
                <div class="image-bg"></div>
                <div class="image-main">
                     <img src="{{ asset('images/Picsart_25-12-01_23-33-21-981.jpg.jpeg') }}" alt="Vastraकला  Artist at work" />
                </div>
            </div>
            
            <div class="about-content">
                <span class="text-primary fw-bold text-uppercase ls-3 small">The Journey</span>
                <h1 class="about-title">Behind the Art of <span class="text-primary">Vastraकला</span></h1>
                
                <p style="font-size: 1.1rem; line-height: 1.8; color: var(--text-body); margin-bottom: 2rem;">
                    The name Vastraकला represents more than just a brand; it’s a commitment to preserving the warmth of handmade art in a world of mass production.
                </p>
                
                <p style="font-size: 1.05rem; line-height: 1.8; color: var(--text-body); margin-bottom: 2.5rem;">
                    Every T-shirt, quilt, and rumal I design is a canvas where stories come to life. Using high-quality colors and intricate detailing, I ensure that each creation is a unique treasure for your little ones.
                </p>

                <div class="features-grid">
                    <div style="background: var(--surface-card); padding: 2rem; border-radius: 30px; box-shadow: var(--shadow-soft); border: 1px solid var(--glass-border);">
                        <i class="fa-solid fa-heart-pulse" style="color: var(--accent-main); font-size: 2rem; margin-bottom: 1rem;"></i>
                        <h3 style="font-family: 'Playfair Display', serif; margin-bottom: 0.5rem; font-size: 1.2rem; color: var(--text-header);">Made with Love</h3>
                        <p style="font-size: 0.85rem; color: var(--text-body);">Passionate craftsmanship in every single stitch.</p>
                    </div>
                    <div style="background: var(--surface-card); padding: 2rem; border-radius: 30px; box-shadow: var(--shadow-soft); border: 1px solid var(--glass-border);">
                        <i class="fa-solid fa-paint-brush" style="color: var(--accent-main); font-size: 2rem; margin-bottom: 1rem;"></i>
                        <h3 style="font-family: 'Playfair Display', serif; margin-bottom: 0.5rem; font-size: 1.2rem; color: var(--text-header);">Pure Handmade</h3>
                        <p style="font-size: 0.85rem; color: var(--text-body);">100% artistic touch with no machine prints.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
