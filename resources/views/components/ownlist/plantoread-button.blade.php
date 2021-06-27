@props(['story'])

<a href="{{ route('ownlist.list-as', $story) . '?my_status=reading' }}"
class="bg-gray-300 text-gray-900 rounded hover:bg-gray-200 text-xs px-3 py-1 focus:outline-none"
>{{ __('plan-to-read') }}</a>
