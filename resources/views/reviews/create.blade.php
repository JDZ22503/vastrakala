@extends('layouts.public')

@section('title', 'Write a Review')

@section('styles')
<style>
    .review-container {
        max-width: 800px;
        margin: 0 auto 100px;
        padding: 50px;
        background: var(--surface-card);
        border-radius: 30px;
        box-shadow: var(--shadow-hover);
        border: 1px solid rgba(173, 139, 115, 0.1);
    }

    .section-title {
        font-family: var(--font-heading);
        font-size: 2.5rem;
        color: var(--text-header);
        margin-bottom: 1rem;
        text-align: center;
    }

    .section-subtitle {
        text-align: center;
        color: var(--text-muted);
        margin-bottom: 3rem;
        font-size: 1.1rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        color: var(--text-header);
        margin-bottom: 0.5rem;
        display: block;
    }

    .form-control {
        background: var(--bg-cream);
        border: 2px solid transparent;
        border-radius: 12px;
        padding: 12px 20px;
        transition: all 0.3s ease;
        color: var(--text-body);
    }

    .form-control:focus {
        border-color: var(--accent-main);
        background: var(--surface-card);
        box-shadow: none;
    }

    /* Star Rating Styling */
    .rating-wrapper {
        display: flex;
        flex-direction: row-reverse;
        justify-content: center;
        gap: 10px;
        margin-bottom: 1rem;
    }

    .rating-wrapper input {
        display: none;
    }

    .rating-wrapper label {
        cursor: pointer;
        width: 40px;
        height: 40px;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23AD8B73' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'%3E%3C/polygon%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: center;
        background-size: contain;
        transition: all 0.2s ease;
    }

    .rating-wrapper label:hover,
    .rating-wrapper label:hover ~ label,
    .rating-wrapper input:checked ~ label {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23AD8B73' stroke='%23AD8B73' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'%3E%3C/polygon%3E%3C/svg%3E");
        transform: scale(1.1);
    }

    .submit-btn {
        background: var(--accent-main);
        color: white;
        border: none;
        padding: 15px 40px;
        border-radius: 50px;
        font-weight: 700;
        font-family: var(--font-body);
        letter-spacing: 1px;
        width: 100%;
        margin-top: 20px;
        transition: all 0.3s ease;
    }

    .submit-btn:hover {
        background: #5d4a42;
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(126, 98, 88, 0.3);
    }

    .alert-success {
        background-color: #d1e7dd;
        border-color: #badbcc;
        color: #0f5132;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 30px;
        text-align: center;
    }

    @media (max-width: 768px) {
        .review-container {
            margin: 0 10px 60px;
            padding: 30px 15px;
            border-radius: 20px;
            width: auto;
            max-width: none;
        }

        .section-title {
            font-size: 1.7rem;
            word-wrap: break-word;
        }

        .section-subtitle {
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
            padding: 0 5px;
        }

        .rating-wrapper {
            gap: 5px;
        }

        .rating-wrapper label {
            width: 28px;
            height: 28px;
        }

        .submit-btn {
            padding: 12px 20px;
            font-size: 0.9rem;
        }
    }

    /* Prevent horizontal overflow globally on this page */
    body {
        overflow-x: hidden;
        width: 100%;
        position: relative;
    }
</style>
@endsection

@section('content')
<section class="section">

<div class="container mt-5 mt-sm-10">
    <div class="review-container mb-3">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            </div>
        @endif

        <h1 class="section-title">Share Your Experience</h1>
        <p class="section-subtitle">We'd love to hear your thoughts on our hand-painted artistry.</p>

        <form action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="rating-group mb-5">
                <label class="form-label text-center">Your Rating</label>
                <div class="rating-wrapper">
                    <input type="radio" id="star5" name="rating" value="5" checked /><label for="star5" title="5 stars"></label>
                    <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="4 stars"></label>
                    <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="3 stars"></label>
                    <input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="2 stars"></label>
                    <input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="1 star"></label>
                </div>
                @error('rating')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <div class="row g-3">
                <div class="col-md-6 form-group">
                    <label for="customer_name" class="form-label">Full Name</label>
                    <input type="text" name="customer_name" id="customer_name" class="form-control" placeholder="John Doe" value="{{ old('customer_name') }}" required>
                    @error('customer_name')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6 form-group">
                    <label for="customer_designation" class="form-label">Designation/Tagline (e.g. Happy Parent)</label>
                    <input type="text" name="customer_designation" id="customer_designation" class="form-control" placeholder="City or Role" value="{{ old('customer_designation') }}">
                </div>
            </div>

            <div class="form-group mt-3">
                <label for="comment" class="form-label">Your Review</label>
                <textarea name="comment" id="comment" rows="5" class="form-control" placeholder="Tell us what you liked about our work..." required>{{ old('comment') }}</textarea>
                @error('comment')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label for="avatar" class="form-label">Your Profile Photo / Product Photo (Optional)</label>
                <input type="file" name="avatar" id="avatar" class="form-control" accept="image/*">
                <small class="text-muted">Will be displayed next to your review.</small>
                @error('avatar')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="submit-btn mt-4">
                Submit Review <i class="fa-solid fa-paper-plane ms-2"></i>
            </button>
        </form>
    </div>
</div>
</section>

@endsection
