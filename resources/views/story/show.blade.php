<x-app-layout>
    <x-slot name="header">
    </x-slot>
    <x-slot name="slot">
        <div class="flex space-x-4">
            {{-- side panel --}}
            <div class="flex-none pr-3" style="box-shadow: 19px 0 0px -18px #e5e7eb;">
                <div class="cover-container w-32 md:w-48 lg:w-64 h-auto m-auto mb-3">
                    <img
                        class=""
                        src="{{ $story->cover ? asset($story->cover) : asset('img/noimagefound.jpg') }}"
                        alt="cover image"
                        >
                </div>
                <div class="font-bold">Status</div>
                <hr class="mb-2">
                @if (!auth()->check() || empty($story['readers'][0]))
                    <x-ownlist.addstory-link story_id="{{ $story->id }}"/>
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
                                    <select name="my_status" value="Status"
                                        class="p-0 pr-6 text-xs"
                                    >
                                        @foreach(['reading','complete','on-hold','dropped','plan to read'] as $my_status)
                                        <option value="{{ $my_status }}" {{ $my_status === $story['readers'][0]['listed']['my_status'] ? 'selected' : '' }}>{{ Str::ucfirst($my_status) }}{{ $my_status == $story['readers'][0]['listed']['my_status'] ? ' (Selected)' : '' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex">
                                    <div class="flex-1">Chapters read:</div>
                                    <div class="">
                                        <input class="p-0 text-xs w-8 text-right" style="line-height:12px;" type="text" name="progress" value="{{ $story['readers'][0]['listed']['progress'] ?? '' }}">
                                        <span>/{{ $story['readers']['chapters'] ?? __('Unknown') }}</span>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="flex-1">Your score:</div>
                                    <div class="">
                                        <select name="rating" value="Rating"
                                            class="p-0 text-xs"
                                        >
                                            <option {{ $story['readers'][0]['listed']['rating'] == null ? 'selected="selected"' : '' }} value="">Select</option>
                                            @foreach(ratingNames() as $rating)
                                            <option {{ $story['readers'][0]['listed']['rating'] == $loop->remaining+1 ? 'selected="selected"' : '' }} value="{{ $loop->remaining+1 }}">({{ $loop->remaining+1 }}) {{ $rating }}</option>
                                            @endforeach
                                        </select>
                                        {{-- {{ $story['readers'][0]['listed']['rating'] ?? __('None') }} --}}
                                    </div>
                                </div>
                                <div class="text-right">
                                    <x-button nopadding class="mt-2 px-3 py-1">Update</x-button>
                                </div>
                            </div>
                        </form>
                    </div>

                @endif
                {{-- <hr class="my-2"> --}}
                <div class="mt-4 font-bold">Statistics</div>
                <hr class="mb-2">
                <div class="flex gap-5">
                    <div>score</div>
                </div>
                <div>number of users listed story</div>
                <div class="flex gap-5">
                    <div>{{ $story->readersCount }}</div>
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
                    <div class="flex items-baseline">
                        <h4 class="flex-1 text-4xl font-bold font-serif text-gray-900">
                            {{ $story->title }}
                        </h4>
                        <h5 class="text-xl text-gray-700">
                            <a href="{{ route('author.show', $story->author) }}">
                                by {{ $story->author->name }}
                            </a>
                        </h5>
                    </div>
                    @if ($story['full_title'] !== null)
                        <div>{{ $story['full_title'] }}</div>
                    @endif
                    <hr class="mb-2">
                    <div class="flex gap-5">
                        <div>score</div>
                        <div>number of users listed story</div>
                    </div>
                    <div class="flex gap-5">
                        <div>ranked #</div>
                        <div>popularity#</div>
                    </div>
                    <hr>
                    <div>synopsis</div>
                    <div>taglist</div>
                </div>
                <div class="flex-auto">
                    Reviews
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>
