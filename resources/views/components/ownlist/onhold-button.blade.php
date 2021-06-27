@props(['story'])

<a href="{{ route('ownlist.list-as', $story) . '?my_status=dropped' }}"
class="bg-yellow-400 text-gray-800 rounded hover:bg-yellow-300 text-xs px-3 py-1 focus:outline-none"
>{{ __('on-hold') }}</a>
