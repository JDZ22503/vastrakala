<x-app-layout>
    <x-slot name="header">
        {{ config('app.name', 'Vastralkala') }} | {{ __('Categories') }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-[#4A403A]" style="font-family: 'Playfair Display', serif;">Manage Categories</h1>
                    <p class="text-[#7E635A]">Organize your gallery into collections.</p>
                </div>
            </div>

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

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <!-- Add Category Form -->
                <div class="bg-white rounded-[30px] overflow-hidden shadow-sm p-8 border border-[#D1A392]/20 h-fit">
                    <h3 class="font-bold text-[#4A403A] mb-4 text-lg">Add New Category</h3>
                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-4">
                            <label class="block text-sm font-bold text-[#7E635A] mb-2">Category Name</label>
                            <x-text-input type="text" name="name" placeholder="e.g. Blankets" required class="w-full" />
                        </div>
                        <x-primary-button class="w-full justify-center">
                            Save Category
                        </x-primary-button>
                    </form>
                </div>

                <!-- List Categories -->
                <div class="md:col-span-2 space-y-4">
                    @forelse($categories as $category)
                        <div class="bg-white rounded-[20px] overflow-hidden shadow-sm p-6 border border-transparent hover:border-[#D1A392] transition-all flex justify-between items-center">
                            <div>
                                <h4 class="font-bold text-[#4A403A] text-lg">{{ $category->name }}</h4>
                                <span class="text-xs text-[#7E635A] bg-[#FCF8F3] px-2 py-1 rounded-md">{{ $category->slug }}</span>
                            </div>
                            
                            <div class="flex items-center gap-4">
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure? This will delete the category and all associated photos from your gallery!')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-sm bg-red-50 px-3 py-1 rounded-md">Delete</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="py-12 text-center bg-white rounded-[40px]">
                            <p class="text-[#7E635A]">No categories found.</p>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
