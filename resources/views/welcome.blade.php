<x-app-layout-v2>
    <x-slot name="body">
        <main class="container mx-auto pt-12 pb-8 min-h-full">
            {{-- <x-auth-validation-errors :errors="$errors" class="container shadow mb-2 items-start justify-between
                bg-red-500 text-white font-bold py-6 px-10 " />
            @if (session('status'));
                @if (session('status')['type'] == 'success');
                    <div class="alert-banner relative">
                        <label
                            class="w-full mb-2 flex items-start justify-between bg-green-400 text-white font-bold shadow py-4 px-10"
                            for="success-banner">
                            <div class="">
                                {{ session('status')['msg'] }}
                            </div>
                        </label>
                    </div>
                @endif
            @endif --}}

            <!-- Page Content -->
            <div class="flex flex-col sm:flex-row gap-12">
                <div class="sm:ml-auto sm:w-6/12">
                    <x-card>
                        <x-slot name="header">
                            Bem vindo(a)!
                        </x-slot>
                        <p>
                            Catalogue suas histórias favoritas ao redor da Web!
                        </p>
                        <p>
                            Dê nota, marque seu progresso, e compartilhe seu perfil com amigos.
                        </p>
                    </x-card>
                </div>
                <div class="sm:w-3/12">
                    <x-card>
                        <x-slot name="header">
                            Últimas histórias
                        </x-slot>
                        <ul>
                            @forelse ($stories as $story)
                            <li class="mb-2">
                                <div class="flex">
                                    <div class="flex-shrink-0 border border-gray-300 self-center">
                                        <a href="{{ route('story.show', $story->slug) }}">
                                            <img
                                            src="{{ $story->cover ? asset('storage/img/'. $story->cover) : asset('img/noimagefound.jpg') }}"
                                                alt="cover image" class="max-h-12" style="max-width:48px;">
                                        </a>
                                    </div>
                                    <div class="ml-1 overflow-hidden whitespace-nowrap">
                                        <div>
                                            <a class="font-bold text-gray-600" href="{{ route('story.show', $story->slug) }}">{{ $story->title }}</a>
                                        </div>
                                        <div>
                                            por <a href="{{ route('author.show', $story->author->slug) }}">{{ $story->author->name }}</a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @empty
                            <li>Sem histórias para mostrar</li>
                            @endforelse
                        </ul>
                    </x-card>
                </div>
            </div>

        </main>

    </x-slot>
</x-app-layout-v2>
