<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            {{ __('Edit Story') }}
        </h2>
    </x-slot>

    <x-slot name="slot">
        <form action="{{ route('story.edit') }}" method="post">
            @csrf
            <div class="flex flex-wrap flex-row gap-6">
                <div class="">
                    <x-label for="title" :value="__('Title')"/>
                    <x-input id="title" name="title" class="block mt-1 w-full"
                        required autocomplete="title" value="{{ old('title', $story->title) }}" />
                </div>
                <div class="form-item">
                    <x-label for="author" :value="__('Author')"/>
                    <x-input id="author" name="author" class="block mt-1 w-full"
                    required autocomplete="author" value="{{ old('author', $story->author) }}" />
                </div>
                <div class="form-item">
                    <x-label for="status" :value="__('Status')"/>
                    <select id="status" name="status"
                    required autocomplete="status"
                    class="rounded-md shadow-sm border border-gray-300">
                        <option {{ old('status', $story->status) == 'incomplete' ? 'selected' : '' }} value="incomplete">Incomplete</option>
                        <option {{ old('status', $story->status) == 'complete' ? 'selected' : '' }} value="complete">Complete</option>
                    </select>
                </div>
                <x-select name="fandom" value="Fandom">
                    @foreach(fandoms() as $fandom)
                    <option :value="$fandom" {{ old('fandom', $story->fandom) == $fandom ? 'selected' : '' }}>{{ Str::ucfirst($fandom) }}</option>
                    {{-- <option value="original">Original</option> --}}
                    @endforeach
                </x-select>
                {{-- <x-form-item class="w-full" name="fandom" required autocomplete>Fandom</x-form-item> --}}
                <x-form-item class="w-full" name="link_sb" autocomplete>Link</x-form-item>
            </div>
            <x-button class="mt-2">
                {{ __('Confirm') }}
            </x-button>
        </form>
    </x-slot>
</x-app-layout>
