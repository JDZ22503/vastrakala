<x-app-layout>
    <x-slot name="header">
        {{ config('app.name', 'Vastralkala') }} | {{ __('Testimonials Management') }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-[#4A403A]" style="font-family: 'Playfair Display', serif;">Customer Testimonials</h1>
                    <p class="text-[#7E635A]">You have {{ $testimonials->count() }} reviews published.</p>
                </div>
                <x-primary-button onclick="window.location='{{ route('admin.testimonials.create') }}'">
                    Add Testimonial +
                </x-primary-button>
            </div>

            @if(session('success'))
                <div class="bg-[#E6FFFA] text-[#2C7A7B] p-4 rounded-[20px] mb-8 text-center font-bold border border-[#2C7A7B]/10">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($testimonials as $testimonial)
                    <div class="bg-white rounded-[40px] p-8 shadow-sm hover:shadow-md transition-all border border-transparent hover:border-[#D1A392]/30 flex flex-col justify-between">
                        <div>
                            <div class="flex gap-1 text-yellow-400 mb-6">
                                @for($i=0; $i<$testimonial->rating; $i++)
                                    <i class="fa-solid fa-star text-xs"></i>
                                @endfor
                            </div>
                            <p class="text-[#4A403A] italic leading-relaxed mb-8">"{{ $testimonial->content }}"</p>
                        </div>

                        <div class="flex items-center justify-between pt-6 border-t border-gray-50">
                            <div class="flex items-center gap-3">
                                @if($testimonial->avatar_path)
                                    <img src="{{ asset($testimonial->avatar_path) }}" class="w-10 h-10 rounded-full object-cover shadow-sm">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-[#FCF8F3] flex items-center justify-center text-[#D1A392] font-bold text-sm">
                                        {{ substr($testimonial->customer_name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <h4 class="font-bold text-[#4A403A] text-sm">{{ $testimonial->customer_name }}</h4>
                                    <p class="text-[0.65rem] text-[#7E635A] uppercase tracking-wider">{{ $testimonial->customer_designation }}</p>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('admin.testimonials.edit', $testimonial->id) }}" class="p-2 text-[#D1A392] hover:bg-[#FCF8F3] rounded-full transition-colors"><i class="fa-solid fa-pen-to-square"></i></a>
                                <form action="{{ route('admin.testimonials.destroy', $testimonial->id) }}" method="POST" onsubmit="return confirm('Delete this creation?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-400 hover:bg-red-50 rounded-full transition-colors"><i class="fa-solid fa-trash"></i></button>
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
</x-app-layout>
