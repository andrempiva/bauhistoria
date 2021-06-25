<div class="w-max">
    @if($tags->isNotEmpty())
    <div class="mb-4 bg-gray-100 border border-gray-200 shadow p-4 rounded-lg w-max max-w-min text-center">
        <form action="{{ route('story.tag.assign', $story->slug) }}" method="post">
            @csrf
            <select class="block mb-2 rounded-md shadow-sm border border-gray-300" name="tag" id="tag">
                @foreach ($tags as $tag)
                <option value="{{ $tag->id }}">{{ "{$tag->name} ({$tag->stories_count})" }}</option>
                @endforeach
            </select>
            <x-button>Adicionar tag</x-button>
        </form>
    </div>
    @endif
    <div class="mx-auto w-max">
        <x-button-link href="{{ route('tags.create', [ 'story' =>   $story->slug]) }}">Criar tag</x-button-link>
    </div>
</div>
