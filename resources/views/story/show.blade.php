<x-app-layout-v2>
    <x-slot name="header">
    </x-slot>
    <x-slot name="slot">
        <div class="flex space-x-4">
            {{-- side panel --}}
            <div class="flex-none pr-3" style="box-shadow: 19px 0 0px -18px #e5e7eb;">
                <div class="cover-container w-32 md:w-48 lg:w-64 h-auto m-auto mb-3">
                    <img class="" src="{{ $story->cover ? asset($story->cover) : asset('img/noimagefound.jpg') }}"
                        alt="cover image">
                </div>
                <div class="font-bold">Status</div>
                <hr class="mb-2">
                @if (!auth()->check() || empty($story['readers'][0]))
                    <x-ownlist.addstory-link story_id="{{ $story->id }}" />
                @else
                    <div>
                        {{-- <span>Edit Listing</span> --}}
                        {{-- <form method="GET" action="{{ route('ownlist.listAs', $story->id) }}"> --}}
                        <form method="POST" action="{{ route('ownlist.update', $story->id) }}">
                            @csrf
                            {{-- <div class="grid grid-cols-2 gap-2 text-sm"> --}}
                            <div class="text-sm" style="line-height:24px;">
                                <div class="flex">
                                    <div class="flex-1 pr-2">Status:</div>
                                    <select name="my_status" value="Status" class="p-0 pr-6 text-xs">
                                        @foreach (['reading', 'complete', 'on-hold', 'dropped', 'plan to read'] as $my_status)
                                            <option value="{{ $my_status }}"
                                                {{ $my_status === $story['readers'][0]['listed']['my_status'] ? 'selected' : '' }}>
                                                {{ Str::ucfirst($my_status) }}{{ $my_status == $story['readers'][0]['listed']['my_status'] ? ' (Selected)' : '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex">
                                    <div class="flex-1">{{ __('Chapters read') }}:</div>
                                    <div class="">
                                        <input class="p-0 text-xs w-8 text-right" style="line-height:12px;" type="text"
                                            name="progress"
                                            value="{{ $story['readers'][0]['listed']['progress'] ?? '' }}">
                                        <span>/{{ $story['readers']['chapters'] ?? __('Unknown') }}</span>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="flex-1">{{ __('Your score') }}:</div>
                                    <div class="">
                                        <select name="rating" value="Rating" class="p-0 text-xs">
                                            <option
                                                {{ $story['readers'][0]['listed']['rating'] == null ? 'selected="selected"' : '' }}
                                                value="">{{ __('Selected') }}</option>
                                            @foreach (ratingNames() as $rating)
                                                <option
                                                    {{ $story['readers'][0]['listed']['rating'] == $loop->remaining + 1 ? 'selected="selected"' : '' }}
                                                    value="{{ $loop->remaining + 1 }}">({{ $loop->remaining + 1 }})
                                                    {{ $rating }}</option>
                                            @endforeach
                                        </select>
                                        {{-- {{ $story['readers'][0]['listed']['rating'] ?? __('None') }} --}}
                                    </div>
                                </div>
                                <div class="text-right">
                                    <x-button nopadding class="mt-2 px-3 py-1">{{ __('Update') }}</x-button>
                                </div>
                            </div>
                        </form>
                    </div>

                @endif
                {{-- <hr class="my-2"> --}}
                <div class="mt-4 font-bold">Statistics</div>
                <hr class="mb-2">
                <div class="flex gap-5">
                    <div>score {{ $story->score }}</div>
                </div>
                <div>number of users listed story</div>
                <div class="flex gap-5">
                    <div>{{ $story->loadCount('readers')->readers_count }} readers</div>
                    {{-- <div>{{ $story->readers_count }}</div> --}}
                    <div>popularity#</div>
                </div>

                {{-- <div>Status: {{ ucwords($story['readers'][0]['listed']['my_status']) }}</div> --}}
                {{-- <div>Chapters read: {{ $story['readers'][0]['listed']['progress'] ?? __('Unknown') }}</div> --}}
                {{-- <div>Your score: {{ $story['readers'][0]['listed']['rating'] ?? __('None') }}</div> --}}
                <div>edit story</div>
            </div>
            {{-- Middle panel --}}
            <div class="flex-auto">
                {{-- {{ $user }} --}}
                {{-- {{ $story }} --}}
                <div class="flex flex-col">
                    {{-- <div class="flex items-baseline"> --}}
                    <div class="">
                        <h4 class="flex-1 text-4xl font-bold font-serif text-gray-900">
                            {{ $story->title }}
                        </h4>
                        <h5 class="text-xl text-gray-700">
                            <a href="{{ route('author.show', $story->author) }}">
                                {{ __('by') }} {{ $story->author->name }}
                            </a>
                        </h5>
                    </div>
                    @if ($story['full_title'] !== null)
                        <div>{{ $story['full_title'] }}</div>
                    @endif
                    <hr class="mb-2">
                    <div>
                        Fandom: {{ Str::ucfirst(Str::replaceArray('-', [' '], $story->fandom)) ?? __('Unknown') }}
                    </div>
                    <td class="text-center">
                        {{ Str::ucfirst($story->type) ?? __("Unknown") }}
                    </td>
                    <td class="text-center">
                        {{ __(Str::ucfirst($story->story_status)) ?? __("Unknown") }}
                    </td>
                    <div class="flex gap-5">
                        <div>{{ __("Average score") }}:</div>
                        <div class="text-center">
                            @if($story->score > 0)
                            <div class="text-4xl font-bold">{{ formatScore($story->score) }}</div>
                            @else
                            <div class="text-4xl font-bold" title="{{ __("Insuficient data") }}">--</div>
                            @endif
                        </div>
                    </div>
                    <div>number of users listed story</div>
                    <div class="flex gap-5">
                        <div>ranked #</div>
                        <div>popularity#</div>
                    </div>
                    <hr>
                    <div>
                        <h3>Sinopse:</h3>
                        @if ($story->synopsis)
                        <div>{{ $story->synopsis }}</div>
                        @else
                        <div>
                            <span>Essa história ainda não tem uma sinopse.</span>
                            <a style="letter-spacing: 0.1em;" class="text-blue-400" href="">Adicionar?</a>
                        </div>
                        @endif
                    </div>
                    <hr>
                    {{-- <div>
                        <h3>Tags:</h3>
                        @foreach ($story->tags as $tag)
                            <span>{{ $tag }} </span>
                        @endforeach
                        <a class="border b-gray-400 w-" href="">+</a>

                    </div>
                    <hr> --}}
                    <div>{{ trans_choice('story.words', $story->words) }}</div>
                    <div>{{ trans_choice('story.chapters', $story->chapters) }}</div>
                    <div class="text-center">
                        <div>{{ $story->story_created_at ?? __("Unknown") }}</div>
                    </div>
                    <div class="text-center">
                        <div>{{ $story->story_updated_at ?? __("Unknown") }}</div>
                    </div>
                </div>
                <hr>
                <div class="flex-auto">
                    Reviews
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout-v2>
