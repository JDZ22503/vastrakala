<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-8 py-3 bg-[#D1A392] border border-transparent rounded-[50px] font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#7E635A] focus:outline-none focus:ring-2 focus:ring-[#D1A392] focus:ring-offset-2 transition ease-in-out duration-150 shadow-md transform hover:-translate-y-1']) }}>
    {{ $slot }}
</button>
