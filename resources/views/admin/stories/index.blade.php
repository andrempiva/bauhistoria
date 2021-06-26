<x-admin-layout>
    <x-slot name="title">Admin Histórias</x-slot>
    <x-slot name="header">
        <div class="flex justify-between items-center flex-wrap">
            {{ __('Histórias') }}
            <form class="font-normal text-sm flex flex-col lg:flex-row lg:w-min gap-2" method="GET" action="{{ route('admin.stories.index') }}">
                <div>
                    Ordernar por: <select class="py-0" name="sort_by" id="sort_by">
                        <option value="id">ID</option>
                        <option value="author_id" {{ request()->get('sort_by') == 'author_id' ? 'selected=selected' : '' }}>ID do Autor</option>
                        <option value="updated" {{ request()->get('sort_by') == 'updated' ? 'selected=selected' : '' }}>Modificada</option>
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
            @foreach ($stories as $story)
                <li
                    class="text-gray-800 bg-gray-{{ $loop->even ? '50' : '200' }}
                    {{ !$loop->last ? 'border-b' : '' }} p-2
                    flex gap-4 items-center">
                    <div class="flex-shrink">#{{ $story->id }}</div>
                    <div class="flex flex-col self-stretch justify-between">
                        <a href="{{ route('admin.stories.edit', [$story->id]) }}">
                            <h1 class="title text-lg text-gray-900 hover:underline hover:text-indigo-900">
                                {{ $story->title }}</h1>
                        </a>
                        <h2 class="title text-base text-gray-600 ">
                            por <a class="text-gray-800 hover:underline hover:text-indigo-800" href="{{ route('admin.authors.edit', [$story->id]) }}">
                                {{ $story->author->name }}
                            </a>
                        </h2>
                        <p><span class="font-bold text-sm">Modificada:</span> {{ $story->updated_at->diffForHumans() }}, {{ $story->updated_at }}</p>
                        <p><span class="font-bold text-sm">Cadastrada:</span> {{ $story->created_at->diffForHumans() }}, {{ $story->created_at }}</p>
                    </div>

                    <form
                        class="ml-auto"
                        method="post" action="{{ route('admin.stories.destroy', [$story->id]) }}">
                        @csrf @method('delete')
                        <div class="field is-grouped text-right">
                            <div class="control mb-2">
                                <a href="{{ route('admin.stories.edit', $story) }}" class="inline-flex items-center bg-gray-700 border border-transparent
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
