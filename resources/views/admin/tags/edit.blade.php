<x-admin-layout>
    <x-slot name="title">Admin - Editar Tag</x-slot>

    {{-- replace admin layout body --}}
    <x-slot name="body">
        <x-card>
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800">
                    {{ __('Editar Tag') }}
                </h2>
            </x-slot>
            <form action="{{ route('admin.authors.update', $tag) }}" method="post">
                @csrf
                <div class="flex gap-6">
                    <div class="w-max flex flex-col flex-wrap justify-between content-start gap-2">
                        <div class="form-item inline-block w-80">
                            <x-label for="name">{{ __('Name') }}<span class="ordinal text-red-600 font-bold">*</span></x-label>
                            <x-input id="name" name="name" class="block mt-1 w-full"
                                required autocomplete="off" value="{{ old('name', $tag->name) }}" />
                        </div>
                    </div>
                </div>

                <div class="flex place-content-start">
                    <x-button type="submit" class="mt-4">Gravar Modificações</x-button>
                </div>
            </form>
        </x-card>
        <x-card>
            <x-slot name="header">
                Histórias Taggeadas
            </x-slot>
            <div>
                <table class="w-full shadow story_index_table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($tag->stories as $story)
                    <tr class="
                    @if ($loop->even)
                    bg-white
                    @else
                    bg-gray-100
                    @endif
                    ">
                        <td class="text-center">#{{ $story->id }}</td>
                        <td><a href="{{ route('admin.stories.edit', $story) }}">{{ $story->title }}</a></td>
                        <td class="text-center">
                            <form method="POST" action="{{ route('admin.tags.remove', ['tag' => $tag, 'story' => $story]) }}">
                                @csrf @method('delete')
                                <button type="submit" class="bg-red-500 text-gray-200 rounded hover:bg-red-400 px-4 py-2 focus:outline-none">Remover</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </x-card>
    </x-slot>
</x-admin-layout>
