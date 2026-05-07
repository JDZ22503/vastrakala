<x-app-layout>
    <x-slot name="header">
        {{ config('app.name', 'Vastralkala') }} | {{ __('Customer Reviews') }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-[#4A403A]" style="font-family: 'Playfair Display', serif;">Customer Reviews</h1>
                    <p class="text-[#7E635A]">Manage reviews submitted by customers.</p>
                </div>
                <div class="bg-white px-4 py-2 rounded-full shadow-sm border border-gray-100 flex items-center gap-4">
                    <span class="text-xs font-bold uppercase tracking-wider text-[#7E635A]">Quick Link:</span>
                    <a href="{{ route('reviews.create') }}" target="_blank" class="text-[0.7rem] font-bold text-[#D1A392] hover:underline">
                        {{ route('reviews.create') }} <i class="fa-solid fa-external-link ms-1"></i>
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-[#E6FFFA] text-[#2C7A7B] p-4 rounded-[20px] mb-8 text-center font-bold border border-[#2C7A7B]/10">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($reviews as $review)
                    <div class="bg-white rounded-[40px] p-8 shadow-sm hover:shadow-md transition-all border {{ $review->is_approved ? 'border-transparent' : 'border-[#D1A392]/50 bg-[#FCF8F3]/30' }} flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-6">
                                <div class="flex gap-1 text-yellow-400">
                                    @for($i=0; $i<$review->rating; $i++)
                                        <i class="fa-solid fa-star text-xs"></i>
                                    @endfor
                                </div>
                                @if(!$review->is_approved)
                                    <span class="px-3 py-1 bg-amber-100 text-amber-700 text-[0.6rem] font-black uppercase tracking-tighter rounded-full">Pending Approval</span>
                                @else
                                    <span class="px-3 py-1 bg-green-100 text-green-700 text-[0.6rem] font-black uppercase tracking-tighter rounded-full">Approved</span>
                                @endif
                            </div>
                            <p class="text-[#4A403A] italic leading-relaxed mb-8">"{{ $review->comment }}"</p>
                        </div>

                        <div class="flex items-center justify-between pt-6 border-t border-gray-50">
                            <div class="flex items-center gap-3">
                                @if($review->avatar_path)
                                    <img src="{{ asset($review->avatar_path) }}" class="w-10 h-10 rounded-full object-cover shadow-sm">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-[#FCF8F3] flex items-center justify-center text-[#D1A392] font-bold text-sm">
                                        {{ substr($review->customer_name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <h4 class="font-bold text-[#4A403A] text-sm">{{ $review->customer_name }}</h4>
                                    <p class="text-[0.65rem] text-[#7E635A] uppercase tracking-wider">{{ $review->customer_designation }}</p>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <form action="{{ route('admin.reviews.toggle_approval', $review->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="p-2 {{ $review->is_approved ? 'text-amber-500 hover:bg-amber-50' : 'text-green-500 hover:bg-green-50' }} rounded-full transition-colors" title="{{ $review->is_approved ? 'Unapprove' : 'Approve' }}">
                                        @if($review->is_approved)
                                            <i class="fa-solid fa-circle-xmark"></i>
                                        @else
                                            <i class="fa-solid fa-circle-check"></i>
                                        @endif
                                    </button>
                                </form>
                                <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Delete this review?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-400 hover:bg-red-50 rounded-full transition-colors"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center bg-white rounded-[40px] border-2 border-dashed border-gray-100">
                        <p class="text-[#7E635A]">No reviews submitted yet.</p>
                        <p class="text-[0.8rem] text-[#D1A392] mt-2">Send the link above to your customers!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
