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

                        <!-- Viral Referral Toggle -->
                        <div class="col-span-1 md:col-span-2 mt-4 pt-6 border-t border-gray-100">
                            <div class="flex items-center justify-between p-6 bg-gray-50 rounded-[30px] border border-gray-100 shadow-sm">
                                <div class="pe-4">
                                    <label class="block text-sm font-bold text-gray-800 mb-1">Viral Referral System</label>
                                    <p class="text-xs text-gray-500 leading-relaxed">Toggle the "Refer-a-Friend" section and the Exit-Intent prize popup on your public website.</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <label class="switch-container" style="position: relative; display: inline-block; width: 60px; height: 34px;">
                                        <input type="checkbox" id="ref_toggle_input" value="1" {{ ($settings['show_referral'] ?? '1') == '1' ? 'checked' : '' }} style="opacity: 0; width: 0; height: 0; position: absolute;" 
                                               onchange="saveReferralToggle(this.checked)">
                                        <span class="slider" style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .4s; border-radius: 34px;"></span>
                                        <style>
                                            #ref_toggle_input:checked + .slider { background-color: #7e6258 !important; }
                                            .switch-container .slider:before {
                                                position: absolute; content: ""; height: 26px; width: 26px; left: 4px; bottom: 4px;
                                                background-color: white; transition: .4s; border-radius: 50%;
                                            }
                                            #ref_toggle_input:checked + .slider:before { transform: translateX(26px); }
                                            
                                            .save-toast {
                                                position: fixed; bottom: 20px; right: 20px; background: #333; color: #fff;
                                                padding: 10px 20px; border-radius: 10px; font-size: 14px; display: none; z-index: 9999;
                                            }
                                        </style>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="ajaxToast" class="save-toast">Setting Saved!</div>

                    <script>
                        function saveReferralToggle(isChecked) {
                            const value = isChecked ? '1' : '0';
                            const toast = document.getElementById('ajaxToast');
                            
                            // Visual feedback
                            toast.style.display = 'block';
                            toast.innerText = 'Saving...';

                            fetch("{{ route('settings.update') }}", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/x-www-form-urlencoded",
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                },
                                body: "show_referral=" + value
                            })
                            .then(response => {
                                toast.innerText = 'Setting Saved!';
                                setTimeout(() => toast.style.display = 'none', 2000);
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                toast.innerText = 'Error saving setting';
                                setTimeout(() => toast.style.display = 'none', 3000);
                            });
                        }
                    </script>

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
