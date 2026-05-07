@extends('layouts.public')

@section('title', 'Gallery')

@section('content')
    <section class="section">
        <div class="container mt-5 mt-sm-10">
            <div class="filter-nav-container">
                <select id="gallery-filter" class="filter-dropdown">
                    <option value="all">All Collections</option>
                    @foreach($categories as $category)
                        @if($category->galleries->count() > 0)
                            <option value="cat-{{ $category->slug }}">{{ $category->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>

                @foreach($categories as $category)
                    @if($category->galleries->count() > 0)
                        <div class="gallery-category-section filter-item" id="cat-{{ $category->slug }}">
                            <h2 class="category-title">{{ $category->name }}</h2>
                            <div class="gallery-grid">
                                @foreach($category->galleries as $item)
                                    <a href="{{ route('gallery.show', $item->slug) }}" class="card" style="text-decoration: none; color: inherit;">
                                        @if($item->badge)
                                            <span class="card-badge">{{ $item->badge }}</span>
                                        @endif
                                        <div class="card-img-wrapper">
                                            @if($item->primaryImage)
                                                <img
                                                    src="{{ asset($item->primaryImage->image_path) }}"
                                                    alt="{{ $item->title }} - Handmade VastraKala Art"
                                                    class="card-img"
                                                    loading="lazy"
                                                />
                                            @else
                                                <div class="card-img" style="background:var(--bg-cream); display:flex; align-items:center; justify-content:center; color:var(--primary-light)">No Image</div>
                                            @endif
                                        </div>
                                        <div class="card-content">
                                            <h3>{{ $item->title }}</h3>
                                            <p style="color: var(--text-light); font-size: 0.9rem;">
                                                {{ Str::limit($item->description, 80) }}
                                            </p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </section>

        <!-- Gallery Filter Logic -->
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const filterDropdown = document.getElementById('gallery-filter');
                const filterItems = document.querySelectorAll('.filter-item');

                if (filterDropdown) {
                    filterDropdown.addEventListener('change', (e) => {
                        const filterValue = e.target.value;

                        filterItems.forEach(item => {
                            if (filterValue === 'all') {
                                item.style.display = 'block';
                            } else if (item.id === filterValue) {
                                item.style.display = 'block';
                            } else {
                                item.style.display = 'none';
                            }
                        });
                    });
                }
            });
        </script>

        @endsection
