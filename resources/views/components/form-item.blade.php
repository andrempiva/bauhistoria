@props(['class' => '', 'name', 'required' => false, 'autocomplete' => false ])

@php
    $autocomplete = $autocomplete ? $name : '';
@endphp

<div class="form-item {{ $class }}">
    <x-label for="{{ $name }}" :value="$slot"/>
    <x-input id="{{ $name }}" name="{{ $name }}" :required="$required"
        :class="'block mt-1 w-full'" :autocomplete="$autocomplete"
    />
</div>
