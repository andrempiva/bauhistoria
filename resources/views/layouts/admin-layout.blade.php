<x-app-layout-v2>
    @if(isset($title))
    <x-slot name="title">{{ $title }}</x-slot>
    @endif
    <x-slot name="body">
        <main class="container mx-auto pt-12 pb-8 min-h-full flex flex-col">
            <!-- Page Content -->
            <div class="flex flex-row gap-12 place-items-start">
                <div class="w-3/12">
                    <x-admin-menu></x-admin-menu>
                </div>
                <div class="w-6/12 mr-auto">
                    <x-session-status/>
                    <x-card>
                        <x-slot name="header">
                            @if(isset($header))
                            {{ $header }}
                            @else
                            {{ __('Administração') }}
                            @endif
                        </x-slot>
                        {{ $slot }}
                    </x-card>
                </div>
                {{-- <div class="w-3/12">
                </div> --}}
            </div>

        </main>

    </x-slot>
</x-app-layout-v2>
