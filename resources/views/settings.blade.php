<x-app-layout>
    <x-slot name="header">
        {{ config('app.name', 'Vastralkala') }} | {{ __('Site Settings') }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-[30px] p-10 border border-gray-100">
                <h2 style="margin-bottom: 2rem; color: var(--primary); font-family: 'Playfair Display', serif;">Update Site Information</h2>
                
                @if(session('success'))
                    <div style="background: #e6fffa; color: #2c7a7b; padding: 1rem; border-radius: 10px; margin-bottom: 2rem; text-align: center;">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('settings.update') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-group">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Office/Studio Address</label>
                            <x-text-input type="text" name="address" :value="$settings['address'] ?? ''" class="w-full" placeholder="Enter address" />
                        </div>
                        
                        <div class="form-group">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Official Phone Number</label>
                            <x-text-input type="text" name="phone" :value="$settings['phone'] ?? ''" class="w-full" placeholder="Enter phone number" />
                        </div>
                        
                        <div class="form-group">
                            <label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp (with country code, no +)</label>
                            <x-text-input type="text" name="whatsapp" :value="$settings['whatsapp'] ?? ''" class="w-full" placeholder="e.g. 919876543210" />
                        </div>
                        
                        <div class="form-group">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Instagram URL</label>
                            <x-text-input type="text" name="instagram" :value="$settings['instagram'] ?? ''" class="w-full" placeholder="Enter Instagram profile URL" />
                        </div>

                        <div class="form-group">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Official Email Address</label>
                            <x-text-input type="email" name="email" :value="$settings['email'] ?? ''" class="w-full" placeholder="Enter email address" />
                        </div>
                    </div>

                    <div class="mt-10">
                        <x-primary-button class="w-full justify-center">
                            Save All Settings 
                        </x-primary-button>
                    </div>
                </form>

                <div style="text-align: center; margin-top: 2rem;">
                    <a href="{{ route('dashboard') }}" style="color: var(--text-light); text-decoration: none;">&larr; Back to Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
