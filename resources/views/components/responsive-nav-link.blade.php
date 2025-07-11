@props(['active'])

@php
$classes = ($active ?? false)
    ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-[#9C773A] text-start text-base font-medium text-[#111010] bg-[#FFEDCF] focus:outline-none focus:text-[#111010] focus:bg-[#CCAD7A] focus:border-[#9C773A] transition duration-150 ease-in-out'
    : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-[#111010] hover:text-[#9C773A] hover:bg-[#FFEDCF] hover:border-[#CCAD7A] focus:outline-none focus:text-[#9C773A] focus:bg-[#FFEDCF] focus:border-[#CCAD7A] transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
