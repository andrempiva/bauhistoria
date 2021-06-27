@props(['story'])

<a href="{{ route('ownlist.list-as', $story) . '?my_status=on-hold' }}"
class="bg-blue-600 text-gray-200 rounded hover:bg-blue-500 text-xs px-3 py-1 focus:outline-none"
>{{ __('completed') }}</a>
