<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            {{ __('author.title', ['author'=> $author->name]) }}
        </h2>
    </x-slot>

    <x-slot name="slot">
        <div>{{ $author->name }}</div>
        <div class="">
            <h4>{{ __('Stories') }}</h4>
            <h4>Todas histórias por {{ $author->name }}</h4>
            {{-- @dump($author->stories) --}}
            <table class="author_story_table">
            <thead>
                <th></th>
                <th>Title</th>
                <th>Extended Title</th>
                <th>Type</th>
                <th>Fandom</th>
                <th>Status</th>
                <th>Length</th>
                <th>Created</th>
                <th>Last Upated</th>
            </thead>
            <tbody>
                @foreach ($author->stories as $story)
                <tr>
                    <td class="cover">
                        <a href="{{ route('story.show', $story) }}">
                            {{-- {{ $story->cover }} --}}
                            <img src="https://via.placeholder.com/60x60" alt="">
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('story.show', $story) }}">
                            {{ $story->title }}
                        </a>
                    </td>
                    <td>
                        {{ $story->full_title ?? "No full title" }}
                    </td>
                    <td>
                        {{ $story->type ?? "Unknown" }}
                    </td>
                    <td>
                        {{ $story->fandom ?? "Unknown" }}
                    </td>
                    <td>
                        {{ $story->story_status ?? "Unknown" }}
                    </td>
                    <td>
                        <div>{{ $story->words ?? "Unknown" }} words</div>
                        <div>{{ $story->chapters ?? "Unknown" }}</div>
                    </td>
                    <td>
                        <div>{{ $story->story_created_at ?? "Unknown" }}</div>
                    </td>
                    <td>
                        <div>{{ $story->story_updated_at ?? "Unknown" }}</div>
                    </td>
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>
    </x-slot>
</x-app-layout>
