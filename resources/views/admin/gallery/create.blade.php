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
                        <textarea id="summernote-description" name="description" placeholder="Size, material, and other technical details..." class="w-full border-gray-300 focus:border-[#D1A392] focus:ring-[#D1A392] rounded-[20px] shadow-sm resize-none p-4"></textarea>
                    </div>

                    <div class="form-group">
                        <label class="block text-sm font-bold text-[#7E635A] mb-2">Behind the Craft (Artisan's Story)</label>
                        <textarea id="summernote-artisan" name="artisan_note" placeholder="Share the soulful story, the inspiration, or the journey behind this piece..." class="w-full border-gray-300 focus:border-[#D1A392] focus:ring-[#D1A392] rounded-[20px] shadow-sm resize-none p-4 bg-[#FCF8F3]/50 border-double border-2 border-[#D1A392]/30" style="font-style: italic;"></textarea>
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
        // Helper function to compress large files client-side
        function compressImage(file, maxSizeBytes = 5 * 1024 * 1024) {
            return new Promise((resolve) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = new Image();
                    img.onload = function() {
                        const canvas = document.createElement('canvas');
                        let width = img.width;
                        let height = img.height;
                        
                        // Limit maximum dimension to 2048px to prevent huge memory usage and reduce size
                        const maxDimension = 2048;
                        if (width > maxDimension || height > maxDimension) {
                            if (width > height) {
                                height = Math.round((height * maxDimension) / width);
                                width = maxDimension;
                            } else {
                                width = Math.round((width * maxDimension) / height);
                                height = maxDimension;
                            }
                        }
                        
                        canvas.width = width;
                        canvas.height = height;
                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(img, 0, 0, width, height);
                        
                        // Start with 0.8 quality jpeg
                        canvas.toBlob((blob) => {
                            if (!blob) {
                                resolve(file);
                                return;
                            }
                            
                            let compressedFile = new File([blob], file.name.substring(0, file.name.lastIndexOf('.')) + '.jpg', {
                                type: 'image/jpeg',
                                lastModified: Date.now()
                            });
                            
                            // If still larger than allowed limit, compress further at 0.5 quality
                            if (compressedFile.size > maxSizeBytes) {
                                canvas.toBlob((blob2) => {
                                    if (blob2) {
                                        compressedFile = new File([blob2], compressedFile.name, {
                                            type: 'image/jpeg',
                                            lastModified: Date.now()
                                        });
                                    }
                                    resolve(compressedFile);
                                }, 'image/jpeg', 0.5);
                            } else {
                                resolve(compressedFile);
                            }
                        }, 'image/jpeg', 0.8);
                    };
                    img.src = e.target.result;
                };
                reader.readAsDataURL(file);
            });
        }

        document.getElementById('image-upload').addEventListener('change', async function(event) {
            const container = document.getElementById('image-preview');
            container.innerHTML = '';
            
            const files = event.target.files;
            if (files && files.length > 0) {
                const dt = new DataTransfer();
                let showLoader = false;
                
                // Check if any file needs compression (>5MB)
                for (let file of files) {
                    if (file.size > 5 * 1024 * 1024) {
                        showLoader = true;
                        break;
                    }
                }
                
                if (showLoader) {
                    Swal.fire({
                        title: 'Optimizing Images...',
                        text: 'Compressing large files to ensure fast upload times.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                }
                
                for (let file of files) {
                    if (file.size > 5 * 1024 * 1024) {
                        // Compress the file
                        const compressedFile = await compressImage(file);
                        dt.items.add(compressedFile);
                    } else {
                        dt.items.add(file);
                    }
                }
                
                // Update file input with compressed list
                event.target.files = dt.files;
                
                // Show previews
                Array.from(dt.files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('preview-thumb');
                        container.appendChild(img);
                    }
                    reader.readAsDataURL(file);
                });
                
                if (showLoader) {
                    Swal.close();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Large images compressed successfully!',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            }
        });
    </script>

    @push('scripts')
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Summernote Lite CSS/JS -->
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#summernote-description').summernote({
                    placeholder: 'Size, material, and other technical details...',
                    tabsize: 2,
                    height: 150,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'italic', 'underline', 'clear']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link']],
                        ['view', ['fullscreen', 'codeview']]
                    ]
                });
                $('#summernote-artisan').summernote({
                    placeholder: "Share the soulful story, the inspiration, or the journey behind this piece...",
                    tabsize: 2,
                    height: 200,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'italic', 'underline', 'clear']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link']],
                        ['view', ['fullscreen', 'codeview']]
                    ]
                });
            });
        </script>
        <style>
            .note-editor.note-frame {
                border: 1px solid #D1A392 !important;
                border-radius: 20px !important;
                overflow: hidden;
                background: white !important;
                font-family: 'Outfit', sans-serif !important;
            }
            .note-toolbar {
                background-color: #FCF8F3 !important;
                border-bottom: 1px solid #D1A392 !important;
                padding: 10px !important;
            }
            .note-btn {
                background: white !important;
                border: 1px solid #D1A392/30 !important;
                color: #7E635A !important;
            }
            .note-btn:hover {
                background: #FCF8F3 !important;
            }
            .note-dropdown-menu {
                background: white !important;
            }
        </style>
    @endpush
</x-app-layout>
