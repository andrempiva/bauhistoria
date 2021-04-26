<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <x-slot name="slot">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="shadow bg-white py-2 px-3">

                @include('story.index')

            </div>
        </div>
    </x-slot>
</x-app-layout>
