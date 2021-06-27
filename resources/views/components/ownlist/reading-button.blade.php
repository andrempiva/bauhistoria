@props(['story'])

<a href="{{ route('ownlist.list-as', $story) . '?my_status=completed' }}"
class="bg-green-500 text-gray-100 rounded hover:bg-green-400 text-xs px-3 py-1 focus:outline-none"
>{{ __('reading') }}</a>
