@props(['class' => '', 'name', 'required' => false, 'autocomplete' => 'off' ])

<div class="form-item {{ $class }}">
    <x-label for="{{ $name }}" :value="$slot"/>
    <x-input {{ $attributes->merge(['class' => 'block mt-1 w-full', 'id' => $name, 'name' => $name]) }}/>
</div>
