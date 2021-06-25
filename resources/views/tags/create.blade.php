<x-app-layout-v2>
    <x-slot name="header">
    </x-slot>
    <x-slot name="slot">
        {{-- <div class="mb-4 font-bold text-xl text-gray-500">
            <a class="" href="{{ url()->previous() }}"><- Voltar</a>
        </div> --}}
        {{-- <div class="mb-4">
            <a href=""><- Voltar</a>
        </div> --}}
        <h2>Criar nova tag</h2>

        <form action="{{ route('tags.store') }}" method="post">
            @csrf

            @if (Request::has('story'))
                <input type="hidden" name="story-slug" value="{{ request()->get('story') }}">
            @endif

            {{-- <div class="flex flex-wrap flex-row mb-4 gap-6"> --}}
            <div class="form-item max-w-xs">
                <x-label for="name" :value="__('Name')" />
                <x-input id="name" name="name" class="block mt-1 w-full" required autocomplete="name"
                    value="{{ old('name') }}" />
            </div>

            <x-label class="form-item max-w-sm" style="max-width: 400px;">
                <span>Descrição (opcional)</span>
                <textarea
                    id="description" name="description"
                    class="form-textarea mt-1 block w-full
                    rounded-md shadow-sm border border-gray-300 p-1.5 focus:border-indigo-300
                    focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    rows="3"></textarea>
            </x-label>
            <div class="flex items-start my-4">
                <x-button class="">
                    {{ __('Confirm') }}
                </x-button>
            </div>
        </form>
    </x-slot>
</x-app-layout-v2>
