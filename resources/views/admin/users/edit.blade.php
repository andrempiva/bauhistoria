<x-admin-layout>
    <x-slot name="title">Admin - Editar Usuário</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            {{ __('Edit User') }}
        </h2>
    </x-slot>
    <x-slot name="slot">
        <form action="{{ route('admin.users.update', $user) }}" method="post">
            @csrf
            <div class="flex gap-6">
                <div class="w-full flex flex-col flex-wrap justify-between content-start gap-2">
                    <div class="form-item inline-block w-80">
                        <x-label for="name">{{ __('Name') }}<span class="ordinal text-red-600 font-bold">*</span></x-label>
                        <x-input id="name" name="name" class="block mt-1 w-full"
                            required autocomplete="off" value="{{ old('name', $user->name) }}" />
                    </div>
                    <div class="form-item inline-block w-80">
                        <x-label for="email">{{ __('Email') }}<span class="ordinal text-red-600 font-bold">*</span></x-label>
                        <x-input id="email" name="email" class="block mt-1 w-full"
                        required autocomplete="off" value="{{ old('email', $user->email) }}" />
                    </div>
                    <div class="form-item inline-block w-80">
                        <x-label for="password">{{ __('Password') }}</x-label>
                        <x-input type="password" id="password" name="password" class="block mt-1 w-full"
                        autocomplete="off"/>
                    </div>
                    <div class="form-item inline-block w-80">
                        <x-label for="password_confirmation">{{ __('Confirmar Senha') }}</x-label>
                        <x-input type="password_confirmation" id="password_confirmation" name="password_confirmation" class="block mt-1 w-full"
                        autocomplete="off"/>
                    </div>
                </div>
            </div>

            <div class="border border-red-300 rounded-lg mt-4 p-2 w-max">
                <div class="flex place-items-center">
                    <input type="checkbox" name="is_admin" id="is_banned" {{ $user->banned_at ? 'checked' : '' }}>
                    <x-label class="pl-2" for="is_banned">Banir Usuário</x-label>
                </div>
                @if ($user->banned_at)
                <p>Usuário banido em {{ $user->banned_at }}, {{ $user->banned_at->diffForHumans() }}</p>
                @endif
            </div>

            <div class="border border-blue-300 rounded-lg mt-4 p-2 w-max">
                <div class="flex place-items-center">
                    <input type="checkbox" name="is_admin" id="is_admin" {{ $user->is_admin ? 'checked' : '' }}>
                    <x-label class="pl-2" for="is_admin">É Admin</x-label>
                </div>
            </div>

            <div class="flex place-content-start">
                <x-button type="submit" class="mt-4">Gravar Modificações</x-button>
            </div>
        </form>
    </x-slot>
</x-admin-layout>
