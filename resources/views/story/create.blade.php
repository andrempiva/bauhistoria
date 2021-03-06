<x-app-layout-v2>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            {{ __('Create Story') }}
        </h2>
    </x-slot>

    <x-slot name="slot">
        <form action="{{ route('story.store') }}" method="post">
            @csrf
            <div class="flex flex-wrap flex-row mb-4 gap-6">
                <div class="">
                    <x-label for="title" :value="__('Title')"/>
                    <x-input id="title" name="title" class="block mt-1 w-full"
                        required autocomplete="off" value="{{ old('title') }}" />
                </div>
                <div class="form-item">
                    <x-label for="author" :value="__('Author')"/>
                    <x-input id="author" name="author" class="block mt-1 w-full"
                    required autocomplete="off" value="{{ old('author') }}" />
                    <label for="author" class="text-xs text-gray-500">Se não existir, o autor novo será criado</label>
                </div>
                <div class="form-item">
                    <x-label for="story_status" :value="__('Status')"/>
                    <select id="story_status" name="story_status"
                    required autocomplete="off"
                    class="rounded-md shadow-sm border border-gray-300">
                        @foreach (storyStatusList() as $status)
                            <option value="{{ $status }}">{{ __($status) }}</option>
                        @endforeach
                        {{-- <option value="incomplete">Incomplete</option> --}}
                        {{-- <option value="complete">Complete</option> --}}
                    </select>
                </div>
                <x-select name="fandom" value="Fandom">
                    @foreach(fandomList() as $fandom)
                    <option value="{{ $fandom }}">{{ __($fandom) }}</option>
                    {{-- <option value="original">Original</option> --}}
                    @endforeach
                </x-select>
            </div>
            <div class="flex items-start my-4">
                <x-form-item class="w-full" name="link" autocomplete="off">Link</x-form-item>
            </div>
            <div class="flex items-start my-4">
                <x-button class="">
                    {{ __('Confirm') }}
                </x-button>
            </div>
        </form>
    </x-slot>
</x-app-layout-v2>
