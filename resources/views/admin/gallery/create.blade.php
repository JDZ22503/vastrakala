<x-app-layout>
    <x-slot name="header">
        {{ config('app.name', 'Little Baby Creations') }} | {{ __('Add New Creation') }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-[40px] p-12 border border-[#D1A392]/20">
                <h2 style="margin-bottom: 2rem; text-align: center; color: var(--primary); font-family: 'Playfair Display', serif; font-size: 2.5rem;">Magic Details <i class="fa-solid fa-wand-magic-sparkles"></i></h2>
                
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

                <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Top Info Section -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                        <div class="form-group">
                            <label class="block text-sm font-bold text-[#7E635A] mb-2">Category</label>
                            <select name="category_id" required class="w-full border-gray-300 focus:border-[#D1A392] focus:ring-[#D1A392] rounded-[15px] shadow-sm">
                                <option value="">Select Choice</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="block text-sm font-bold text-[#7E635A] mb-2">Product Title</label>
                            <x-text-input type="text" name="title" placeholder="e.g. Handmade T-Shirt" required class="w-full" />
                        </div>

                        <div class="form-group">
                            <label class="block text-sm font-bold text-[#7E635A] mb-2">Badge (Optional)</label>
                            <x-text-input type="text" name="badge" placeholder="e.g. Best Seller" class="w-full" />
                        </div>
                    </div>

                    <!-- Upload Section (Full Width) -->
                    <div class="mt-5 p-8 bg-[#FCF8F3]/30 rounded-[30px] border border-dashed border-[#D1A392]/30 mb-8">
                        <label class="block text-sm font-bold text-[#7E635A] mb-4">Upload Product Images</label>
                        <input type="file" id="image-upload" name="images[]" multiple required class="block w-full text-xs text-[#7E635A] file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-[#FCF8F3] file:text-[#D1A392] hover:file:bg-[#D1A392] hover:file:text-white transition-all cursor-pointer">
                        
                        <!-- Preview Container -->
                        <div id="image-preview" class="grid grid-cols-4 md:grid-cols-8 gap-3 mt-6">
                            <!-- Thumbnails will appear here -->
                        </div>
                        
                        <p class="text-[0.65rem] text-[#7E635A] mt-4 italic">* You can select multiple photos. The first one will be the primary thumbnail. You can reorder them after saving!</p>
                    </div>

                    <!-- Bottom Content Section -->
                    <div class="form-group mb-8">
                        <label class="block text-sm font-bold text-[#7E635A] mb-2">Technical Description</label>
                        <textarea name="description" rows="4" placeholder="Size, material, and other technical details..." class="w-full border-gray-300 focus:border-[#D1A392] focus:ring-[#D1A392] rounded-[20px] shadow-sm resize-none p-4"></textarea>
                    </div>

                    <div class="form-group">
                        <label class="block text-sm font-bold text-[#7E635A] mb-2">Behind the Craft (Artisan's Story)</label>
                        <textarea name="artisan_note" rows="6" placeholder="Share the soulful story, the inspiration, or the journey behind this piece..." class="w-full border-gray-300 focus:border-[#D1A392] focus:ring-[#D1A392] rounded-[20px] shadow-sm resize-none p-4 bg-[#FCF8F3]/50 border-double border-2 border-[#D1A392]/30" style="font-style: italic;"></textarea>
                        <p class="text-[0.7rem] text-[#D1A392] mt-2 font-bold flex items-center gap-2">
                            <i class="fa-solid fa-feather-pointed"></i> This storytelling section helps build trust and increases organic reach on Google.
                        </p>
                    </div>

                    <div class="mt-12">
                        <x-primary-button class="w-full justify-center h-14 rounded-full text-lg shadow-lg">
                            Save Creation <i class="fa-solid fa-wand-magic-sparkles ml-2"></i>
                        </x-primary-button>
                    </div>
                </form>

                <div style="text-align: center; margin-top: 3rem;">
                    <a href="{{ route('admin.gallery.index') }}" style="color: var(--text-light); text-decoration: none; font-size: 0.9rem;" class="hover:underline font-bold">&larr; Back to gallery list</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Preview Script & Style -->
    <style>
        .preview-thumb {
            width: 100%;
            aspect-ratio: 1/1;
            object-fit: cover;
            border-radius: 12px;
            border: 2px solid #FCF8F3;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
    </style>
    <script>
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
    </script>
</x-app-layout>
