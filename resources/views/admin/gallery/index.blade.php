<x-app-layout>
    <x-slot name="header">
        {{ config('app.name', 'Vastralkala') }} | {{ __('Product Gallery Management') }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-[#4A403A]" style="font-family: 'Playfair Display', serif;">Manage your creations</h1>
                    <p class="text-[#7E635A]">You currently have {{ $galleries->count() }} items listed.</p>
                </div>
                <x-primary-button onclick="window.location='{{ route('admin.gallery.create') }}'">
                    Add New Item +
                </x-primary-button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                @forelse($galleries as $item)
                    <div class="bg-white rounded-[30px] overflow-hidden shadow-sm border border-transparent hover:border-[#D1A392] transition-all relative group">
                        <!-- New Arrival Toggle Star (AJAX with direct styles) -->
                        <div style="position: absolute; top: 1rem; right: 1rem; z-index: 50;">
                            <button type="button" 
                                data-url="{{ route('admin.gallery.toggle_new_arrival', $item->id) }}"
                                title="{{ $item->new_arrival ? 'Remove from New Arrivals' : 'Mark as New Arrival' }}" 
                                class="toggle-new-arrival"
                                style="width: 40px; height: 40px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.15); border: none; cursor: pointer; transition: all 0.3s ease;">
                                <i class="fa-solid fa-star" style="font-size: 1.2rem; {{ $item->new_arrival ? 'color: #7E635A;' : 'color: #d1d5db; opacity: 0.6;' }}"></i>
                            </button>
                        </div>

                        @if($item->primaryImage)
                            <img src="{{ asset($item->primaryImage->image_path) }}" alt="{{ $item->title }}" class="w-full aspect-square object-cover">
                        @else
                            <div class="w-full aspect-square bg-gray-100 flex items-center justify-center text-gray-400 text-xs">No image</div>
                        @endif
                        <div class="p-6 text-center">
                            <span class="text-[0.7rem] uppercase tracking-widest text-[#D1A392] font-bold mb-1 block">{{ $item->category->name }}</span>
                            <h3 class="font-bold text-[#4A403A] mb-1 truncate">{{ $item->title }}</h3>
                            <p class="text-xs text-[#7E635A] h-8 overflow-hidden line-clamp-2">{{ html_entity_decode(strip_tags($item->description), ENT_QUOTES, 'UTF-8') }}</p>
                            <div class="flex justify-between items-center mt-4">
                                <a href="{{ route('admin.gallery.edit', $item->id) }}" class="text-xs text-[#D1A392] hover:underline font-bold">Edit <i class="fa-solid fa-pen ml-1"></i></a>
                                <form action="{{ route('admin.gallery.destroy', $item->id) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="delete-btn text-xs text-red-500 hover:underline font-bold">Delete <i class="fa-solid fa-trash ml-1"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center bg-white rounded-[40px]">
                        <p class="text-[#7E635A]">No creations found. Add your first work!</p>
                        <a href="{{ route('admin.gallery.create') }}" class="mt-4 inline-block text-[#D1A392] font-bold hover:underline">Add Now</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            // Toggle New Arrival AJAX
            document.querySelectorAll('.toggle-new-arrival').forEach(button => {
                button.addEventListener('click', function () {
                    const btn = this;
                    const url = btn.getAttribute('data-url');
                    const icon = btn.querySelector('.fa-star');
                    
                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            if (data.is_new_arrival) {
                                icon.style.setProperty('color', '#7E635A', 'important');
                                icon.style.setProperty('opacity', '1', 'important');
                                btn.setAttribute('title', 'Remove from New Arrivals');
                            } else {
                                icon.style.setProperty('color', '#d1d5db', 'important');
                                icon.style.setProperty('opacity', '0.6', 'important');
                                btn.setAttribute('title', 'Mark as New Arrival');
                            }
                            
                            Toast.fire({
                                icon: 'success',
                                title: data.message
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error', 'Something went wrong!', 'error');
                    });
                });
            });

            // SweetAlert for Delete
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('.delete-form');
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This item will be soft-deleted and can be recovered later.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#7E635A',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // Show Session success messages with SweetAlert
            @if(session('success'))
                Toast.fire({
                    icon: 'success',
                    title: "{{ session('success') }}"
                });
            @endif
        });
    </script>
    @endpush
</x-app-layout>
