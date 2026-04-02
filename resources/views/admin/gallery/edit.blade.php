<x-app-layout>
    <x-slot name="header">
        {{ config('app.name', 'Little Baby Creations') }} | {{ __('Edit Creation') }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-[40px] p-12 border border-[#D1A392]/20">                
                <h2 style="margin-bottom: 2rem; text-align: center; color: var(--primary); font-family: 'Playfair Display', serif; font-size: 2.5rem;">Update Magic <i class="fa-solid fa-wand-magic-sparkles"></i></h2>
                
                @if(session('success'))
                    <div style="background: #e6fffa; color: #2c7a7b; padding: 1rem; border-radius: 10px; margin-bottom: 2rem; text-align: center;">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div style="background: #fff5f5; color: #c53030; padding: 1rem; border-radius: 10px; margin-bottom: 2rem; text-align: center;">
                        @foreach($errors->all() as $error)
                            <p class="text-xs font-bold">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('admin.gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <!-- Top Info Section -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                        <div class="form-group">
                            <label class="block text-sm font-bold text-[#7E635A] mb-2">Category</label>
                            <select name="category_id" required class="w-full border-gray-300 focus:border-[#D1A392] focus:ring-[#D1A392] rounded-[15px] shadow-sm">
                                <option value="">Select Choice</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $gallery->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="block text-sm font-bold text-[#7E635A] mb-2">Product Title</label>
                            <x-text-input type="text" name="title" value="{{ $gallery->title }}" placeholder="e.g. Handmade T-Shirt" required class="w-full" />
                        </div>

                        <div class="form-group">
                            <label class="block text-sm font-bold text-[#7E635A] mb-2">Badge (Optional)</label>
                            <x-text-input type="text" name="badge" value="{{ $gallery->badge }}" placeholder="e.g. Best Seller" class="w-full" />
                        </div>
                    </div>

                    <!-- Gallery Section (Full Width) -->
                    <div class="mt-5 p-8 bg-[#FCF8F3]/30 rounded-[30px] border border-dashed border-[#D1A392]/30 mb-8">
                        <label class="block text-sm font-bold text-[#7E635A] mb-4">Manage Photos (Drag to Reorder)</label>
                        
                        <div id="sortable-photos" style="display: flex; flex-wrap: wrap; gap: 1.2rem; margin-bottom: 2rem;">
                            @forelse($gallery->images as $index => $photo)
                                <div class="photo-item" data-id="{{ $photo->id }}" style="position: relative; cursor: move; width: 100px; height: 100px;">
                                    <img src="{{ asset($photo->image_path) }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 18px; border: 4px solid white; box-shadow: 0 8px 15px rgba(0,0,0,0.08);">
                                    
                                    <!-- Order Badge -->
                                    <div class="order-badge" style="position: absolute; bottom: -5px; left: -5px; background: #7E635A; color: white; width: 22px; height: 22px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: bold; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                        {{ $index + 1 }}
                                    </div>

                                    <button type="button" 
                                        onclick="deletePhoto({{ $photo->id }}, this)"
                                        style="position: absolute; top: -10px; right: -10px; background: #ef4444; color: white; width: 28px; height: 28px; border-radius: 50%; border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 4px 8px rgba(0,0,0,0.15); z-index: 10;">
                                        <i class="fa-solid fa-xmark" style="font-size: 14px;"></i>
                                    </button>
                                </div>
                            @empty
                                <div class="w-full py-10 text-center bg-white rounded-[20px]">
                                    <p style="font-size: 0.8rem; color: #D1A392; font-weight: bold;">No photos uploaded yet.</p>
                                </div>
                            @endforelse
                        </div>

                        <div class="mt-6 border-t border-[#D1A392]/10 pt-6">
                            <label class="block text-sm font-bold text-[#7E635A] mb-2">Upload New Images (+)</label>
                            <input type="file" id="image-upload" name="images[]" multiple class="block w-full text-xs text-[#7E635A] file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-[#FCF8F3] file:text-[#D1A392] hover:file:bg-[#D1A392] hover:file:text-white transition-all cursor-pointer">
                            <div id="image-preview" class="grid grid-cols-4 md:grid-cols-8 gap-3 mt-4"></div>
                            <p class="text-[0.65rem] text-[#7E635A] mt-3 italic">* Selected images will be added to the end of the gallery above.</p>
                        </div>
                    </div>

                    <!-- Bottom Content Section -->
                    <div class="form-group">
                        <label class="block text-sm font-bold text-[#7E635A] mb-2">Description / Art Story</label>
                        <textarea name="description" rows="5" placeholder="Tell the story of this creation..." class="w-full border-gray-300 focus:border-[#D1A392] focus:ring-[#D1A392] rounded-[20px] shadow-sm resize-none p-4">{{ $gallery->description }}</textarea>
                    </div>

                    <div class="mt-12">
                        <x-primary-button class="w-full justify-center h-14 rounded-full text-lg shadow-lg">
                            Update Magic <i class="fa-solid fa-wand-magic-sparkles ml-2"></i>
                        </x-primary-button>
                    </div>
                </form>

                <div style="text-align: center; margin-top: 3rem;">
                    <a href="{{ route('admin.gallery.index') }}" style="color: var(--text-light); text-decoration: none; font-size: 0.9rem;" class="hover:underline font-bold">&larr; Back to gallery list</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sortable Logic
            const el = document.getElementById('sortable-photos');
            if (el) {
                new Sortable(el, {
                    animation: 150,
                    ghostClass: 'opacity-50',
                    onEnd: function() {
                        const items = Array.from(el.querySelectorAll('.photo-item'));
                        const order = items.map(item => item.getAttribute('data-id'));
                        
                        // Update visual badges immediately
                        items.forEach((item, idx) => {
                            const badge = item.querySelector('.order-badge');
                            if(badge) badge.innerText = idx + 1;
                        });

                        fetch("{{ route('gallery.photos.reorder') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ order: order })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if(data.success) {
                                // Success
                            }
                        });
                    }
                });
            }

            // Image Preview for New Uploads
            document.getElementById('image-upload').addEventListener('change', function(event) {
                const container = document.getElementById('image-preview');
                container.innerHTML = '';
                
                const files = event.target.files;
                if (files) {
                    Array.from(files).forEach(file => {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.classList.add('preview-thumb');
                            container.appendChild(img);
                        }
                        reader.readAsDataURL(file);
                    });
                }
            });
        });

        function deletePhoto(id, btn) {
            Swal.fire({
                title: 'Delete this photo?',
                text: "This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#7E635A',
                confirmButtonText: 'Yes, delete!'
            }).then((result) => {
                if (result.isConfirmed) {
                    let deleteUrl = "{{ route('gallery.photo.delete', ['photo' => ':id']) }}";
                    deleteUrl = deleteUrl.replace(':id', id);

                    fetch(deleteUrl, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if(data.success) {
                            btn.closest('.photo-item').remove();
                            
                            // Re-index remaining badges
                            const items = Array.from(document.querySelectorAll('#sortable-photos .photo-item'));
                            items.forEach((item, idx) => {
                                const badge = item.querySelector('.order-badge');
                                if(badge) badge.innerText = idx + 1;
                            });

                            Swal.fire('Deleted!', data.message, 'success');
                        }
                    });
                }
            });
        }
    </script>

    <style>
        .preview-thumb {
            width: 100%;
            aspect-ratio: 1/1;
            object-fit: cover;
            border-radius: 12px;
            border: 2px solid #FCF8F3;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
    </style>
</x-app-layout>
