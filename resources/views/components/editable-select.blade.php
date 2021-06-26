@props(['name', 'value'])

<div class="form-item">
    <x-label for="{{ $name }}" :value="{{ $value }}"/>
    <input list="{{ $name.'_list' }}" name="fandom">
    <select id="{{ $name }}" name="{{ $name }}"
        required
        {{ $attributes->merge(['class' => 'rounded-md shadow-sm border border-gray-300']) }}
    >
    <datalist id="{{ $name.'_list' }}">
            {{ $slot }}
    </datalist>
    </select>
</div>





