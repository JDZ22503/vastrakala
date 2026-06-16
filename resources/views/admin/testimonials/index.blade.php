<x-app-layout>
    <x-slot name="header">
        {{ config('app.name', 'Vastralkala') }} | {{ __('Testimonials Management') }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-[#4A403A]" style="font-family: 'Playfair Display', serif;">Customer Testimonials</h1>
                    <p class="text-[#7E635A]">You have {{ $testimonials->where('is_approved', true)->count() }} reviews published.</p>
                </div>
                <div class="flex gap-4 items-center">
                    <div class="bg-white px-4 py-2 rounded-full shadow-sm border border-gray-100 hidden md:flex items-center gap-4">
                        <span class="text-xs font-bold uppercase tracking-wider text-[#7E635A]">Customer Link:</span>
                        <a href="{{ route('reviews.create') }}" target="_blank" class="text-[0.7rem] font-bold text-[#D1A392] hover:underline">
                            {{ route('reviews.create') }} <i class="fa-solid fa-external-link ms-1"></i>
                        </a>
                    </div>
                    <x-primary-button onclick="window.location='{{ route('admin.testimonials.create') }}'">
                        Add Testimonial +
                    </x-primary-button>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-[#E6FFFA] text-[#2C7A7B] p-4 rounded-[20px] mb-8 text-center font-bold border border-[#2C7A7B]/10">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($testimonials as $testimonial)
                    <div class="bg-white rounded-[40px] p-8 shadow-sm hover:shadow-md transition-all border {{ $testimonial->is_approved ? 'border-transparent' : 'border-[#D1A392]/50 bg-[#FCF8F3]/30' }} flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-6">
                                <div class="flex gap-1 text-yellow-400">
                                    @for($i=0; $i<$testimonial->rating; $i++)
                                        <i class="fa-solid fa-star text-xs"></i>
                                    @endfor
                                </div>
                                @if(!$testimonial->is_approved)
                                    <span class="px-3 py-1 bg-amber-100 text-amber-700 text-[0.6rem] font-black uppercase tracking-tighter rounded-full">Pending Approval</span>
                                @endif
                            </div>
                            <p class="text-[#4A403A] italic leading-relaxed mb-8">"{{ $testimonial->content }}"</p>
                        </div>

                        <div class="flex items-center justify-between pt-6 border-t border-gray-50">
                            <div class="flex items-center gap-2 text-left">
                                @if($testimonial->avatar_path)
                                    <img src="{{ asset($testimonial->avatar_path) }}" class="rounded-full object-cover shadow-sm flex-shrink-0" style="width: 24px; height: 24px; aspect-ratio: 1/1;">
                                @else
                                    <div class="rounded-full bg-[#FCF8F3] flex items-center justify-center text-[#D1A392] font-bold text-[10px] flex-shrink-0 border border-[#D1A392]/20" style="width: 24px; height: 24px; aspect-ratio: 1/1;">
                                        {{ substr($testimonial->customer_name, 0, 1) }}
                                    </div>
                                @endif
                                <div class="flex flex-col">
                                    <h4 class="font-bold text-[#4A403A] text-[11px] leading-tight">{{ $testimonial->customer_name }}</h4>
                                    <p class="text-[0.55rem] text-[#7E635A] uppercase tracking-wider">{{ $testimonial->customer_designation }}</p>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <form action="{{ route('admin.testimonials.toggle_approval', $testimonial->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-[0.7rem] font-bold rounded-full transition-colors {{ $testimonial->is_approved ? 'text-amber-600 bg-amber-50 hover:bg-amber-100' : 'text-green-600 bg-green-50 hover:bg-green-100' }}" title="{{ $testimonial->is_approved ? 'Unapprove' : 'Approve' }}">
                                        @if($testimonial->is_approved)
                                            <i class="fa-solid fa-circle-xmark"></i> Disapprove
                                        @else
                                            <i class="fa-solid fa-circle-check"></i> Approve
                                        @endif
                                    </button>
                                </form>
                                <a href="{{ route('admin.testimonials.edit', $testimonial->id) }}" class="p-2 text-[#D1A392] hover:bg-[#FCF8F3] rounded-full transition-colors"><i class="fa-solid fa-pen-to-square"></i></a>
                                <form action="{{ route('admin.testimonials.destroy', $testimonial->id) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="p-2 text-red-400 hover:bg-red-50 rounded-full transition-colors delete-btn"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center bg-white rounded-[40px] border-2 border-dashed border-gray-100">
                        <p class="text-[#7E635A]">No testimonials added yet.</p>
                        <a href="{{ route('admin.testimonials.create') }}" class="text-[#D1A392] font-bold hover:underline mt-2 inline-block">Create the first one &rarr;</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-btn');
            
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    const form = this.closest('.delete-form');
                    
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This testimonial will be moved to trash!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#D1A392',
                        cancelButtonColor: '#7E635A',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel',
                        borderRadius: '20px',
                        background: '#FCF8F3',
                        color: '#4A3F35'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
    @endpush
</x-app-layout>
