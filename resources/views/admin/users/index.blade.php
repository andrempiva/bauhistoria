<x-admin-layout>
    <x-slot name="title">Admin Usuários</x-slot>
    <x-slot name="header">
        <div class="flex justify-between items-center flex-wrap">
            Usuários
            <form class="font-normal text-sm flex flex-col lg:flex-row lg:w-min gap-2" method="GET" action="{{ route('admin.users.index') }}">
                <div>
                    Ordernar por: <select class="py-0" name="sort_by" id="sort_by">
                        <option value="id">ID</option>
                        <option value="alpha" {{ request()->get('sort_by') == 'alpha' ? 'selected=selected' : '' }}>Alfabética</option>
                        <option value="updated" {{ request()->get('sort_by') == 'updated' ? 'selected=selected' : '' }}>Atualizado</option>
                    </select>
                </div>
                <div class="flex lg:block justify-between items-center gap-2">
                    Ordem: <select class="py-0 w-full lg:w-auto" name="order" id="order">
                        <option value="asc">Asc</option>
                        <option value="desc" {{ request()->get('order') == 'desc' ? 'selected=selected' : '' }}>Desc</option>
                    </select>
                </div>
                <button class="font-bold text-gray-600 py-0 px-3 border border-gray-300 shadow-sm
                    rounded-xl bg-white"
                    type="submit">Ordenar</button>
            </form>
        </div>
    </x-slot>
    <x-slot name="slot">
        <ul class="border">
            @foreach ($users as $user)
                <li
                    class="text-gray-800 bg-gray-{{ $loop->even ? '50' : '200' }} flex justify-between items-center {{ !$loop->last ? 'border-b' : '' }} p-2">
                    <div class="flex flex-col self-stretch justify-between">
                        <h1 class="name text-xl text-gray-900">
                            <a class="hover:underline hover:text-indigo-900" href="{{ route('admin.users.edit', $user) }}">
                                {{ $user->name }}
                            </a>
                        </h1>
                        <p><span class="font-bold text-sm">Modificado:</span> {{ $user->updated_at->diffForHumans() }}, {{ $user->updated_at }}</p>
                        <p><span class="font-bold text-sm">Cadastrado:</span> {{ $user->created_at->diffForHumans() }}, {{ $user->created_at }}</p>
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
