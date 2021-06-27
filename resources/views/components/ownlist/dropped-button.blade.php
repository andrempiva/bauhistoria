@props(['story'])

<a href="{{ route('ownlist.list-as', $story) . '?my_status=plan-to-read' }}"
class="bg-red-500 text-gray-200 rounded hover:bg-red-400 text-xs px-3 py-1 focus:outline-none"
>{{ __('dropped') }}</a>
