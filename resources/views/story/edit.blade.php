<x-app-layout-v2>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            {{ __('Edit Story') }}
        </h2>
    </x-slot>

    <x-slot name="slot">
        <form action="{{ request()->routeIs('admin.stories.edit')
            ? route('admin.stories.edit', $story)
            : route('story.edit', $story->slug) }}" method="post">
            @csrf
            <div class="flex gap-6">
                <div class="w-full flex flex-wrap justify-between content-start gap-2">
                    <div class="form-item inline-block w-7/12">
                        <x-label for="title">{{ __('Title') }}<span class="ordinal text-red-600 font-bold">*</span></x-label>
                        <x-input id="title" name="title" class="block mt-1 w-full"
                            required autocomplete="off" value="{{ old('title', $story->title) }}" />
                    </div>
                    <div class="form-item inline-block">
                        <x-label for="author">{{ __('Autor') }}<span class="ordinal text-red-600 font-bold">*</span></x-label>
                        <x-input id="author" name="author" class="block mt-1 w-full"
                        required autocomplete="off" value="{{ old('author', $story->author->name) }}" />
                        <label for="author" class="text-xs text-gray-500">Se não existir, o autor novo será criado</label>
                    </div>
                    <x-form-item class="w-full" name="full_title" autocomplete="off">Título Completo</x-form-item>
                    <x-select name="fandom" value="Fandom">
                        @foreach(fandomList() as $fandom)
                        <option value="{{ $fandom }}" {{ old('fandom', $story->fandom) == $fandom ? 'selected=selected' : '' }}>{{ __(Str::ucfirst($fandom)) }}{{ old('fandom', $story->fandom) == $fandom ? ' (Atual)' : '' }}</option>
                        {{-- <option value="original">Original</option> --}}
                        @endforeach
                    </x-select>
                    <x-select name="type" value="Tipo">
                        @foreach(storyTypeList() as $type)
                        <option value="{{ $type }}" {{ old('type', $story->type) == $type ? 'selected="selected"' : '' }}>{{ __($type) }}{{ old('type', $story->type) == $type ? ' (Atual)' : '' }}</option>
                        {{-- <option value="original">Original</option> --}}
                        @endforeach
                    </x-select>
                    <div class="form-item">
                        <x-label for="story_status" :value="__('Status')"/>
                        <select id="story_status" name="story_status"
                        class="rounded-md shadow-sm border border-gray-300">
                            @foreach (storyStatusList() as $status)
                                <option {{ old('story_status', $story->story_status) == $status ? 'selected="selected"' : '' }} value="{{ $status }}">{{ __(Str::ucfirst($status)) }}{{ old('story_status', $story->story_status) == $status ? ' (Atual)' : '' }}</option>
                            @endforeach
                        </select>
                    </div>

                    <x-form-item class="w-full max-w-prose" name="link_sb" autocomplete="off">Link</x-form-item>
                </div>
                <div class="w-full flex flex-wrap justify-start content-start items-start gap-6">
                    <x-label class="w-full">
                        <span class="block font-medium text-sm text-gray-700">Sinopse</span>
                        <textarea
                            id="description" name="description"
                            class="form-textarea mt-1 block w-full h-32 rounded-md shadow-sm border border-gray-300
                            p-1.5 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
                            rounded-br-none" spellcheck="true" autocomplete="off" maxlength="1024"></textarea>
                    </x-label>
                    <div class="form-item inline-block">
                        <x-label for="words" value="{{ __('Qtd. de Palavras') }}"/>
                        <input type="number" id="words" name="words" class="block mt-1 rounded-md shadow-sm
                            border border-gray-300 p-1.5 focus:border-indigo-300 focus:ring focus:ring-indigo-200
                            focus:ring-opacity-50 w-32" autocomplete="off"
                            value="{{ old('words', $story->words) }}" />
                    </div>
                    <div class="form-item inline-block">
                        <x-label for="chapters" value="{{ __('Qtd. de Capítulos') }}"/>
                        <input type="number" id="chapters" name="chapters" class="block mt-1 rounded-md shadow-sm
                            border border-gray-300 p-1.5 focus:border-indigo-300 focus:ring focus:ring-indigo-200
                            focus:ring-opacity-50 w-32" autocomplete="off"
                            value="{{ old('chapters', $story->chapters) }}" />
                    </div>
                    <div class="form-item inline-block">
                        <x-label for="story_created_at" value="História criada em"/>
                        <input type="date" id="story_created_at" name="story_created_at" class="block mt-1 w-full rounded-md
                            shadow-sm border border-gray-300 p-1.5 focus:border-indigo-300 focus:ring focus:ring-indigo-200
                            focus:ring-opacity-50" autocomplete="off"
                            value="{{ old('story_created_at', $story->story_created_at) }}" />
                    </div>
                    <div class="form-item inline-block">
                        <x-label for="story_updated_at" value="História atualizada em"/>
                        <input type="date" id="story_updated_at" name="story_updated_at" class="block mt-1 w-full rounded-md
                            shadow-sm border border-gray-300 p-1.5 focus:border-indigo-300 focus:ring focus:ring-indigo-200
                            focus:ring-opacity-50" autocomplete="off"
                            value="{{ old('story_updated_at', $story->story_updated_at) }}" />
                    </div>
                </div>
            </div>

            @if(auth()->user()->is_admin)
            <div class="border border-blue-300 rounded-lg mt-4 p-2 w-max">
                <p>Opções de Admin</p>
                <div class="flex place-items-center">
                    <input type="checkbox" name="is_locked" id="is_locked" {{ $story->locked_at ? 'checked' : '' }}>
                    <x-label for="is_locked">🔒 Trancar História</x-label>
                </div>
                <label for="is_locked" class="text-xs text-gray-500">Impede que a história seja editada por usuários</label>
            </div>
            @endif

            <div class="flex place-content-end">
                <x-button type="submit" class="mt-4">Gravar Modificações</x-button>
            </div>
        </form>
    </x-slot>
</x-app-layout-v2>
