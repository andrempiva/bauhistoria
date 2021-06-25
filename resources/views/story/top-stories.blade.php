<x-app-layout-v2>
    <x-slot name="title">Top Histórias</x-slot>
    <x-slot name="header">
        {{ __('Top Stories') }}
    </x-slot>
    <x-slot name="slot">
        <div class="flex justify-between mb-2">
            <h3 class="font-serif text-4xl text-gray-700">
                {{ __('Top Stories') }}
            </h3>
        </div>
        <div class="flex items-center mb-4">
            <a href="{{ route('story.create') }}"
                class="px-4 py-2 bg-gray-800 border
                border-transparent rounded-md font-semibold text-xs text-white
                uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900
                focus:outline-none focus:border-gray-900 focus:ring ring-gray-300
                disabled:opacity-25 transition ease-in-out duration-150 ml-2"
            >
            {{ __('Adicionar uma nova história') }}
            </a>
        </div>
        {{-- tabela de stories --}}
        <table class="shadow story_index_table">
            <thead class="font-semibold">
                <tr class="bg-gray-100">
                    <td>{{ __('Cover') }}</td>
                    <td>{{ __('Title') }}</td>
                    <td>{{ __('Fandom') }}</td>
                    <td>{{ __('Status') }}</td>
                    {{-- <td>{{ __('Length') }}</td> --}}
                    <td>{{ __('Created at') }}</td>
                    <td>{{ __('Updated at') }}</td>
                    <td>{{ __('Score') }}</td>
                    <td></td>
                    {{-- <td>Actions</td> --}}
                </tr>
            </thead>
            @forelse ($stories as $story)
                <tr class="">
                    <td>
                        <a href="{{ route('story.show', $story) }}"
                                @if($story->full_title)
                                title="{{ $story->full_title }}"
                                @endif
                            ><img src="{{ asset("img/60x60.png") }}" alt=""></a>
                    </td>

                    <td>
                        <div class="font-bold text-gray-600">
                            <a href="{{ route('story.show', $story) }}"
                                @if($story->full_title)
                                title="{{ $story->full_title }}"
                                @endif
                            >
                                {{ $story->title }}
                            </a>
                        </div>
                        <div class="text-sm">
                            {{ __('by') }} <a href="{{ route('author.show', $story->author) }}">{{ $story->author->name }}</a>
                        </div>
                    </td>

                    <td>
                        {{-- {{ Str::ucfirst(Str::replaceArray('-', [' '], $story->fandom)) ?? __("Unknown") }} --}}
                        {{  $story->fandom ? __($story->fandom) : __("Unknown") }}
                    </td>

                    <td>
                        {{-- <span>{{ $story->status ?? 'Incomplete' }}</span> --}}
                        {{  $story->story_status ? __($story->story_status) : __("Unknown") }}
                    </td>

                    <td class="hidden md:table-cell">
                        <div>{{ $story->story_created_at ?? __("Unknown") }}</div>
                    </td>

                    <td class="hidden md:table-cell">
                        <div>{{ $story->story_updated_at ?? __("Unknown") }}</div>
                    </td>

                    <td>
                        @if($story->score > 0)
                        <div class="text-4xl font-bold">{{ formatScore($story->score) }}</div>
                        @else
                        <div class="text-4xl font-bold" title="{{ __("Insuficient data") }}">--</div>
                        @endif
                    </td>

                    <td>
                        <div class="flex items-center place-content-evenly">
                            @auth
                            @if($user->isStoryListed($story->id))
                                @php($storyListedAs = $user->getListedStatusOf($story->id))

                                @if ($storyListedAs ==)

                                @else

                                @endif
                            @else
                            {{ __('Add') }}
                            @endif
                            {{-- @php
                                // $hasStory = $user->isStoryListed($user->stories->where('id', $story->id));
                                $hasStory = $user->stories->contains('id', $story->id);
                                // $hasStory = true;
                                // dd($hasStory);
                                // dd($story);
                            @endphp
                            <x-button-link
                                type="" class="
                                    px-2 py-1 border rounded text-xs
                                "
                                href="{{ !$hasStory ? route('ownlist.add', $story->id) . '?status=reading' : route('ownlist.remove', $story->id) }}"
                                    >
                                @if ( !$hasStory )
                                {{ __('Add') }}
                                @else
                                {{ __('Remove') }}
                                @endif --}}
                            </x-button-link>
                            @endauth

                            @guest
                            <x-button-link type="" class=" px-2 py-1 border rounded text-xs "
                                href="{{ route('ownlist.add', $story->id) . '?status=reading' }}" >
                                {{ __('Add') }}
                            </x-button-link>
                            @endguest
                        </div>
                    </td>
                </tr>
            @empty
                <td colspan="5" class="text-center">No stories in the Database</td>
            @endforelse
        </table>
    </x-slot>
</x-app-layout-v2>
