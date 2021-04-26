<x-app-layout>
    <x-slot name="header">
    </x-slot>
    <x-slot name="slot">
        <div class="flex space-x-4">
            <div class="flex-none">
                <img
                    class="h-64 m-auto mb-3"
                    src="{{ $story->cover ? asset($story->cover) : asset('img/noimagefound.jpg') }}"
                    alt="cover image"
                    >
                <div class="font-bold">Edit Status</div>
                <hr class="mb-2">
                @if (!auth()->check() || $listedData['status'] == 'none')
                    <x-ownlist.addstory-link story_id="{{ $story->id }}"/>
                @else
                    <div>
                        {{-- <span>Edit Listing</span> --}}
                        <form action="{{ route('ownlist.add, $story->id') }}" method="post">
                            @csrf
                            {{-- <div class="grid grid-cols-2 gap-2 text-sm"> --}}
                            <div class="text-sm">
                                <div class="flex">
                                    <div class="flex-1 pr-2">Status:</div>
                                    <select name="status" value="Status"
                                        class="p-0 pr-6 text-xs"
                                    >
                                        @foreach(['reading','complete','on-hold','dropped','plan to read'] as $status)
                                        <option value="{{ $status }}" {{ $status === $listedData['status'] ? 'selected' : '' }}>{{ Str::ucfirst($status) }}{{ $status == $listedData['status'] ? ' (Selected)' : '' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex">
                                    <div class="flex-1">Chapters read:</div>
                                    <div class="">
                                        <input type="text" name="progress" value="{{ $listedData['progress'] ?? '' }}">
                                        {{ $listedData['progress'] ?? __('Unknown') }}
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="flex-1">Your score:</div>
                                    <div class="">
                                        <select name="rating" value="Rating"
                                            class="p-0 text-xs"
                                        >
                                            <option {{ $listedData['rating'] == null ? 'selected="selected"' : '' }} >Select</option>
                                            @foreach(ratings() as $rating)
                                            <option {{ $listedData['rating'] == $loop->remaining+1 ? 'selected="selected"' : '' }} value="{{ $loop->remaining+1 }}">({{ $loop->remaining+1 }}) {{ $rating }}</option>
                                            @endforeach
                                        </select>
                                        {{-- {{ $listedData['rating'] ?? __('None') }} --}}
                                    </div>
                                </div>
                                <div class="text-right">
                                    <x-button class="mt-2">Update</x-button>
                                </div>
                            </div>
                        </form>
                        <div>badge list+number</div>
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
                    <div>ranked #</div>
                    <div>popularity#</div>
                </div>

                {{-- <div>Status: {{ ucwords($listedData['status']) }}</div> --}}
                {{-- <div>Chapters read: {{ $listedData['progress'] ?? __('Unknown') }}</div> --}}
                {{-- <div>Your score: {{ $listedData['rating'] ?? __('None') }}</div> --}}
                <div>edit story</div>
            </div>
            <div class="flex-auto">
                {{-- {{ $user }} --}}
                {{-- {{ $story }} --}}
                <div class="flex items-end">
                    <h4 class="flex-1 text-4xl font-bold font-serif text-gray-900">
                        {{ $story->title }}
                    </h4>
                    <h5 class="text-xl text-gray-700">by {{ $story->author }}</h5>
                </div>
                <div>full title</div>
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
        </div>
    </x-slot>
</x-app-layout>
