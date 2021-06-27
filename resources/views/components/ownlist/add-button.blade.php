@props(['story'])

<a href="{{ route('ownlist.add', $story) . '?status=reading' }}"
class="border border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-gray-200 rounded px-3 py-1"
>Adicionar</a>
