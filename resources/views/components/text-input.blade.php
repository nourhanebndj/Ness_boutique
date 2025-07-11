@props(['disabled' => false])

<input 
    @disabled($disabled) 
    {{ $attributes->merge([
        'class' => 'border-[#CCAD7A] focus:border-[#9C773A] focus:ring-[#9C773A] bg-[#FDF8F8] text-[#111010] rounded-md shadow-sm placeholder:text-[#CCAD7A]'
    ]) }}>
