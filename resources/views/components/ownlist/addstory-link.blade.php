@props(['storyId', 'listedAs' => 'reading'])

<x-button-link class="{{ $class ?? '' }}" href="{{ route('ownlist.add', $storyId) . '?status='. $listedAs }}">
    {{ $slot != '' ? $slot : __('Add Story') }}
</x-button-link>
