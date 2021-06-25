<x-app-layout-v2>
    <x-slot name="title">{{ $author->name }}</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            {{ __('author.title', ['author'=> $author->name]) }}
        </h2>
    </x-slot>

    <x-slot name="slot">
        <div class="lg:flex">
        <div class="w-3/12">
            <div class="font-serif text-4xl font-semibold text-gray-700 "
            >{{ $author->name }}</div>
        </div>
        <div class="w-9/12">
            <div class="author-stories mt-3 ">
                {{-- <h4>{{ __('Stories') }}</h4> --}}
                <h4>Todas histórias por {{ $author->name }}</h4>
                {{-- @dump($author->stories) --}}
                <table class="author_story_table">
                <thead>
                    <th></th>
                    <th>{{ __('Title') }}</th>
                    <th>{{ __('Fandom') }}</th>
                    <th>{{ __('Type') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Length') }}</th>
                    <th>{{ __('Created at') }}</th>
                    <th>{{ __('Updated at') }}</th>
                    <th>{{ __('Score') }}</th>
                </thead>
                <tbody>
                    @foreach ($author->stories as $story)
                    <tr>
                        <td class="cover">
                            <a href="{{ route('story.show', $story) }}">
                                {{-- {{ $story->cover }} --}}
                                <img src="{{ asset("img/60x60.png") }}" alt="">
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('story.show', $story) }}"
                                @if($story->full_title)
                                title="{{ $story->full_title }}"
                                @endif
                                >
                                {{ $story->title }}
                            </a>
                        </td>
                        <td>
                            {{ Str::ucfirst(Str::replaceArray('-', [' '], $story->fandom)) ?? __("Unknown") }}
                        </td>
                        <td class="text-center">
                            {{ Str::ucfirst($story->type) ?? __("Unknown") }}
                        </td>
                        <td class="text-center">
                            {{ __(Str::ucfirst($story->story_status)) ?? __("Unknown") }}
                        </td>
                        <td class="text-center">
                            <div>{{ trans_choice('story.words', $story->words) }}</div>
                            <div>{{ trans_choice('story.chapters', $story->chapters) }}</div>
                        </td>
                        <td class="text-center">
                            <div>{{ $story->story_created_at ?? __("Unknown") }}</div>
                        </td>
                        <td class="text-center">
                            <div>{{ $story->story_updated_at ?? __("Unknown") }}</div>
                        </td>
                        <td class="text-center">
                            @if($story->score > 0)
                            <div class="text-4xl font-bold">{{ formatScore($story->score) }}</div>
                            @else
                            <div class="text-4xl font-bold" title="{{ __("Insuficient data") }}">--</div>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                </table>
            </div>
        </div>
    </div>
    </x-slot>
</x-app-layout-v2>
