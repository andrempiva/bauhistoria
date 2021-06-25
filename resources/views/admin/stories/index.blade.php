<x-admin-layout>
    <x-slot name="title">Admin Usuários</x-slot>
    <x-slot name="header">
        {{ __('Usuários') }}
    </x-slot>
    <x-slot name="slot">
        <ul class="border">
            @foreach ($users as $user)
                <li
                    class="text-gray-800 bg-gray-{{ $loop->even ? '50' : '200' }} flex justify-between items-center {{ !$loop->last ? 'border-b' : '' }} p-2">
                    <div class="flex flex-col self-stretch justify-between">
                        <a href="{{ route('admin.users.show', [$user->id]) }}">
                            <h1 class="name text-xl text-gray-900 hover:underline hover:text-indigo-900">
                                {{ $user->name }}</h1>
                        </a>
                        <p><b>Cadastrado:</b> {{ $user->created_at->diffForHumans() }}, {{ $user->created_at }}</p>
                        <p><b>Atualizado:</b> {{ $user->updated_at->diffForHumans() }}, {{ $user->updated_at }}</p>
                    </div>

                    <form method="post" action="{{ route('admin.users.destroy', [$user->id]) }}">
                        @csrf @method('delete')
                        <div class="field is-grouped text-right">
                            <div class="control mb-2">
                                <a href="{{ route('admin.users.edit', [$user->id]) }}" class="inline-flex items-center bg-gray-700 border border-transparent
                                rounded-md font-semibold text-xs text-white uppercase tracking-widest
                                hover:bg-gray-600 active:bg-gray-800 focus:outline-none focus:border-gray-800
                                focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150
                                px-4 py-2">
                                    Editar
                                </a>
                            </div>
                            <div class="control">
                                <button type="submit" class="inline-flex items-center bg-red-800 border border-transparent
                                rounded-md font-semibold text-xs text-white uppercase tracking-widest
                                hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900
                                focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150
                                px-4 py-2">
                                    Deletar
                                </button>
                            </div>
                        </div>
                    </form>
                </li>
            @endforeach
        </ul>
    </x-slot>
</x-admin-layout>
