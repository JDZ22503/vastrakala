@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-[#D1A392] focus:ring-[#D1A392] rounded-[15px] shadow-sm']) }}>
