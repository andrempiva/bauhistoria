@props(['name', 'value'])

<div class="form-item">
    <x-label for="{{ $name }}" value="{{ $value }}"/>
    <select id="{{ $name }}" name="{{ $name }}"
        required autocomplete="{{ $name }}"
        {{ $attributes->merge(['class' => 'rounded-md shadow-sm border border-gray-300']) }}
    >
        {{ $slot }}
    </select>
</div>
