<x-admin-layout>
    <x-slot name="title">Admin - Editar Autor</x-slot>

    {{-- replace admin layout body --}}
    <x-slot name="body">
        <x-card>
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800">
                    {{ __('Editar Autor') }}
                </h2>
            </x-slot>
            <form action="{{ route('admin.authors.update', $author) }}" method="post">
                @csrf
                <div class="flex gap-6">
                    <div class="w-max flex flex-col flex-wrap justify-between content-start gap-2">
                        <div class="form-item inline-block w-80">
                            <x-label for="name">{{ __('Name') }}<span class="ordinal text-red-600 font-bold">*</span></x-label>
                            <x-input id="name" name="name" class="block mt-1 w-full"
                                required autocomplete="off" value="{{ old('name', $author->name) }}" />
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
                <h2 class="font-semibold text-xl text-gray-800">
                    Deletar Autor
                </h2>
            </x-slot>
            Deletar o Autor e trocar as histórias para outro:
            <form x-data="{ really:false }" method="POST" action="{{ route('admin.authors.change-destroy', $author) }}" class="mb-2">
                @csrf
                <div class="w-max flex flex-wrap gap-2 p-3 py-1 border rounded-lg items-center">
                    <div class="form-item">
                        <x-input id="new_author" name="new_author" class="block mt-1 w-max"
                            required autocomplete="off" placeholder="Novo autor" value="{{ old('new_author') }}" />
                        <label for="new_author" class="text-xs text-gray-500">Se não existir, o autor novo será criado</label>
                    </div>
                    <div>
                        <button x-on:click="really=true" type="button" class="bg-yellow-400 text-gray-800 rounded hover:bg-yellow-300 focus:outline-none
                        px-4 py-2 h-12">Deletar e Trocar</button>
                    </div>
                    <div x-show="really">
                        Você tem certeza?
                    </div>
                    <div x-show="really">
                        <button type="submit" class="bg-red-500 text-gray-200 rounded hover:bg-red-400 px-4 py-2 focus:outline-none">Sim</button>
                    </div>
                </div>
            </form>
            <div>
                Deletar o Autor e as histórias:
            </div>
            <form x-data="{ really:false }" class="flex gap-8" method="POST" action="{{ route('admin.authors.destroy', $author) }}" class="">
                <div class="w-max flex flex-wrap content-start gap-2 px-5 py-3 border rounded-lg items-center">
                    @csrf @method('delete')
                    <button x-on:click="really=true" type="button" class="border border-red-500 text-red-500 hover:bg-red-500 hover:text-gray-200 rounded px-4 py-2">
                        Deletar Autor e Histórias
                    </button>
                    <div x-show="really">
                        Você tem certeza?
                    </div>
                    <div x-show="really">
                        <button type="submit" class="bg-red-500 text-gray-200 rounded hover:bg-red-400 px-4 py-2 focus:outline-none">Sim</button>
                    </div>
                </div>
            </form>
        </x-card>
    </x-slot>
</x-admin-layout>
