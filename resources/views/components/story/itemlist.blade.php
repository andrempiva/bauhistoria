<tr class="">
    <x-table-td>
        <img src="https://via.placeholder.com/60x60" alt="">
    </x-table-td>

    <x-table-td>
        <a href="{{ route('story.show', $story) }}">{{ $story->title }}</a>
    </x-table-td>

    <x-table-td>
        <a href="{{ route('author.show', $story->author) }}">{{ $story->author->name }}</a>
    </x-table-td>

    <x-table-td>
        <span>{{ $story->status ?? 'Incomplete' }}</span>
    </x-table-td>

    <x-table-td>
        <div class="flex items-center place-content-evenly">
            @auth
            @php
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
                @endif
            </x-button-link>
            @endauth
        </div>
    </x-table-td>
</tr>
