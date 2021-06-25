<x-app-layout-v2>
    <x-slot name="title">Sobre o Site</x-slot>

    <x-slot name="body">
        <main class="container mx-auto pt-12 pb-8 min-h-full">
            <!-- Page Content -->
            <div class="flex flex-row gap-12">
                <div class="w-6/12 m-auto">
                    <x-card>
                        <x-slot name="header">
                            {{ __('About') }}
                        </x-slot>
                        <p>O Baú de Histórias foi criado como um projeto de conclusão de curso, mas ele já estava em planejamento e é um projetinho perto do meu coração.</p>
                        <p>Criado por André M Piva <span class="text-gray-600 text-sm">(andrempiva arroba gmail ponto com)</span></p>
                    </x-card>
                </div>
                {{-- <div class="w-3/12">
                </div> --}}
            </div>

        </main>

    </x-slot>
</x-app-layout-v2>
