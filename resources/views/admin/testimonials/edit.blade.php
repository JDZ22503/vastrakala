<x-app-layout>
    <x-slot name="header">
        {{ config('app.name', 'Vastralkala') }} | {{ __('Edit Testimonial') }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-[40px] shadow-sm p-10">
                <h1 class="text-2xl font-bold text-[#4A403A] mb-8" style="font-family: 'Playfair Display', serif;">Modify Feedback</h1>

                <form action="{{ route('admin.testimonials.update', $testimonial->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-6 flex items-center gap-6">
                        @if($testimonial->avatar_path)
                            <img src="{{ asset($testimonial->avatar_path) }}" class="w-16 h-16 rounded-full object-cover">
                        @endif
                        <div class="flex-1">
                            <x-input-label for="avatar" :value="__('Change Photo (Optional)')" />
                            <input type="file" name="avatar" class="block mt-1 w-full text-xs text-[#7E635A] file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-[#FCF8F3] file:text-[#D1A392] hover:file:bg-[#D1A392] hover:file:text-white transition-all cursor-pointer">
                        </div>
                        <x-input-error :messages="$errors->get('avatar')" class="mt-2" />
                    </div>

                    <div class="mb-6">
                        <x-input-label for="customer_name" :value="__('Customer Name')" />
                        <x-text-input id="customer_name" class="block mt-1 w-full" type="text" name="customer_name" :value="old('customer_name', $testimonial->customer_name)" required autofocus />
                        <x-input-error :messages="$errors->get('customer_name')" class="mt-2" />
                    </div>

                    <div class="mb-6">
                        <x-input-label for="customer_designation" :value="__('Designation/Tagline')" />
                        <x-text-input id="customer_designation" class="block mt-1 w-full" type="text" name="customer_designation" :value="old('customer_designation', $testimonial->customer_designation)" />
                        <x-input-error :messages="$errors->get('customer_designation')" class="mt-2" />
                    </div>

                    <div class="mb-6">
                        <x-input-label for="rating" :value="__('Rating (1-5)')" />
                        <select name="rating" id="rating" class="block mt-1 w-full border-gray-300 focus:border-[#D1A392] focus:ring-[#D1A392] rounded-md shadow-sm">
                            <option value="5" {{ $testimonial->rating == 5 ? 'selected' : '' }}>5 Stars - Excellent</option>
                            <option value="4" {{ $testimonial->rating == 4 ? 'selected' : '' }}>4 Stars - Good</option>
                            <option value="3" {{ $testimonial->rating == 3 ? 'selected' : '' }}>3 Stars - Average</option>
                            <option value="2" {{ $testimonial->rating == 2 ? 'selected' : '' }}>2 Stars - Poor</option>
                            <option value="1" {{ $testimonial->rating == 1 ? 'selected' : '' }}>1 Star - Very Poor</option>
                        </select>
                        <x-input-error :messages="$errors->get('rating')" class="mt-2" />
                    </div>

                    <div class="mb-8">
                        <x-input-label for="content" :value="__('Testimonial Message')" />
                        <textarea id="content" name="content" rows="4" class="block mt-1 w-full border-gray-300 focus:border-[#D1A392] focus:ring-[#D1A392] rounded-md shadow-sm text-[#4A403A]" required>{{ old('content', $testimonial->content) }}</textarea>
                        <x-input-error :messages="$errors->get('content')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end">
                        <a href="{{ route('admin.testimonials.index') }}" class="mr-4 text-[#7E635A] hover:underline">Cancel</a>
                        <x-primary-button>
                            {{ __('Update Testimonial') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
