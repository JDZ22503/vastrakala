<x-app-layout>
    <x-slot name="header">
        Welcome to {{ config('app.name', 'Vastraकला ') }} Admin
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Manage Categories -->
                <a href="{{ route('admin.categories.index') }}" class="group bg-white overflow-hidden shadow-sm sm:rounded-[30px] p-8 border border-transparent hover:border-[#D1A392] transition-all duration-300">
                    <div class="text-4xl mb-4 group-hover:scale-110 transition-transform text-[#D1A392]"><i class="fa-solid fa-tags"></i></div>
                    <h3 class="text-xl font-bold text-[#4A403A] mb-2" style="font-family: 'Playfair Display', serif;">Categories</h3>
                    <p class="text-sm text-[#7E635A]">Organize and manage your product collections.</p>
                </a>
                
                <!-- Manage Testimonials -->
                <a href="{{ route('admin.testimonials.index') }}" class="group bg-white overflow-hidden shadow-sm sm:rounded-[30px] p-8 border border-transparent hover:border-[#D1A392] transition-all duration-300">
                    <div class="text-4xl mb-4 group-hover:scale-110 transition-transform text-[#D1A392]"><i class="fa-solid fa-comment-dots"></i></div>
                    <h3 class="text-xl font-bold text-[#4A403A] mb-2" style="font-family: 'Playfair Display', serif;">Reviews</h3>
                    <p class="text-sm text-[#7E635A]">Manage customer testimonials and feedback.</p>
                </a>

                <!-- Manage Gallery -->
                <a href="{{ route('admin.gallery.index') }}" class="group bg-white overflow-hidden shadow-sm sm:rounded-[30px] p-8 border border-transparent hover:border-[#D1A392] transition-all duration-300">
                    <div class="text-4xl mb-4 group-hover:scale-110 transition-transform text-[#D1A392]"><i class="fa-solid fa-palette"></i></div>
                    <h3 class="text-xl font-bold text-[#4A403A] mb-2" style="font-family: 'Playfair Display', serif;">Manage Gallery</h3>
                    <p class="text-sm text-[#7E635A]">Add, remove, or edit your baby creations and photos.</p>
                </a>

                <!-- Add New Creation -->
                <a href="{{ route('admin.gallery.create') }}" class="group bg-white overflow-hidden shadow-sm sm:rounded-[30px] p-8 border border-transparent hover:border-[#D1A392] transition-all duration-300">
                    <div class="text-4xl mb-4 group-hover:scale-110 transition-transform text-[#D1A392]"><i class="fa-solid fa-plus-circle"></i></div>
                    <h3 class="text-xl font-bold text-[#4A403A] mb-2" style="font-family: 'Playfair Display', serif;">Add New creation</h3>
                    <p class="text-sm text-[#7E635A]">Quickly upload a new photo and details to your gallery.</p>
                </a>

                <!-- Site Settings -->
                <a href="{{ route('settings.index') }}" class="group bg-white overflow-hidden shadow-sm sm:rounded-[30px] p-8 border border-transparent hover:border-[#D1A392] transition-all duration-300">
                    <div class="text-4xl mb-4 group-hover:scale-110 transition-transform text-[#D1A392]"><i class="fa-solid fa-gear"></i></div>
                    <h3 class="text-xl font-bold text-[#4A403A] mb-2" style="font-family: 'Playfair Display', serif;">Site Settings</h3>
                    <p class="text-sm text-[#7E635A]">Update your address, phone, and social media accounts.</p>
                </a>
            </div>


        </div>
    </div>
</x-app-layout>
