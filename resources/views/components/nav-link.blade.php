@props(['active'])

@php
$classes = ($active ?? false)
    ? 'inline-flex items-center px-1 pt-1 border-b-2 border-[#9C773A] text-sm font-medium leading-5 text-[#111010] focus:outline-none focus:border-[#9C773A] transition duration-150 ease-in-out'
    : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-[#111010] hover:text-[#9C773A] hover:border-[#CCAD7A] focus:outline-none focus:text-[#9C773A] focus:border-[#CCAD7A] transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
