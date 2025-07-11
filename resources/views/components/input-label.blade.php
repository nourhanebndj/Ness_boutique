@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm', 'style' => 'color: #111010']) }}>
    {{ $value ?? $slot }}
</label>
