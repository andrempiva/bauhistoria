<x-app-layout>
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
                        required autocomplete="title" value="{{ old('title') }}" />
                </div>
                <div class="form-item">
                    <x-label for="author" :value="__('Author')"/>
                    <x-input id="author" name="author" class="block mt-1 w-full"
                    required autocomplete="author" value="{{ old('author') }}" />
                </div>
                <div class="form-item">
                    <x-label for="status" :value="__('Status')"/>
                    <select id="status" name="status"
                    required autocomplete="status"
                    class="rounded-md shadow-sm border border-gray-300">
                        <option value="incomplete">Incomplete</option>
                        <option value="complete">Complete</option>
                    </select>
                </div>
                <x-select name="fandom" value="Fandom">
                    @foreach(fandoms() as $fandom)
                    <option value="{{ $fandom }}">{{ Str::ucfirst($fandom) }}</option>
                    {{-- <option value="original">Original</option> --}}
                    @endforeach
                </x-select>
                {{-- <x-form-item class="w-full" name="fandom" required autocomplete>Fandom</x-form-item> --}}
            </div>
            <div class="flex items-start my-4">
                <x-form-item class="w-full" name="link" autocomplete>Link</x-form-item>
            </div>
            <div class="flex items-start my-4">
                <div class="flex items-center h-5">
                    <input id="nsfw" name="nsfw" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                </div>
                <div class="ml-3 text-sm">
                    <label for="nsfw" class="font-medium text-gray-700">NSFW</label>
                    <p class="text-gray-500">Does it contain adult content?</p>
                </div>
            </div>
            <div class="flex items-start my-4">
                <x-button class="">
                    {{ __('Confirm') }}
                </x-button>
            </div>
        </form>
    </x-slot>
</x-app-layout>
