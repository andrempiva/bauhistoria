@props(['story'])

<a href="{{ route('ownlist.add', $story) . '?status=reading' }}"
class="bg-blue-600 text-gray-200 text-xs rounded hover:bg-blue-500 px-3 py-1 focus:outline-none"
>Adicionar</a>
