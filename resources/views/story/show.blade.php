<x-app-layout-v2>
    <x-slot name="title">{{ $story->title }}</x-slot>

    <x-slot name="header">
    </x-slot>
    <x-slot name="slot">
        <div class="flex space-x-4">
            {{-- side panel --}}
            <div class="max-w-min flex-grow pr-3" style="box-shadow: 19px 0 0px -18px #e5e7eb;">
                <div class="cover-container w-32 md:w-48 lg:w-64 h-auto m-auto mb-3">
                    <img class="" src="{{ $story->cover ? asset('storage/img/'. $story->cover) : asset('img/noimagefound.jpg') }}"
                        alt="cover image">
                </div>
                <div class="font-bold mb-2 border-b-2">Seu status</div>
                @if (!auth()->check() || empty($story['readers'][0]))
                <div class="flex place-content-end">
                    <x-ownlist.addstory-link class="" story_id="{{ $story->id }}" >
                        ✚ {{ __('Add Story') }}
                    </x-ownlist.addstory-link>
                </div>
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
                                        {{-- @foreach (['reading', 'complete', 'on-hold', 'dropped', 'plan to read'] as $my_status) --}}
                                        @foreach (listedStatusList() as $my_status)
                                            <option value="{{ $my_status }}"
                                                {{ $my_status === $story['readers'][0]['listed']['my_status'] ? 'selected=selected' : '' }}>
                                                {{ __($my_status) }}{{ $my_status == $story['readers'][0]['listed']['my_status'] ? ' (Atual)' : '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex">
                                    <div class="flex-1">{{ __('Chapters read') }}:</div>
                                    <div class="">
                                        <input class="p-0 text-xs w-8 text-right" style="line-height:12px;" type="text"
                                            name="progress" autocomplete="off"
                                            value="{{ $story['readers'][0]['listed']['progress'] ?? '' }}">
                                        <span>/{{ $story['readers']['chapters'] ?? " --" }}</span>
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
                                    <x-button nopadding class="mt-2 px-3 py-1">{{ __('Update Status') }}</x-button>
                                </div>
                            </div>
                        </form>
                    </div>

                @endif
                <div class="text-right">
                    <x-button-link href="{{ route('story.edit', $story) }}" class="mt-2">Editar História</x-button-link>
                </div>
            </div>

            {{-- Middle panel --}}
            <div class="flex-auto flex-col">
                <div class="flex flex-col">
                    <h2 class="flex-1 text-4xl font-bold font-serif text-gray-900">
                        {{ $story->title }}
                    </h2>
                    <div class="flex justify-between items-end gap-4">
                        <h5 class="font-light text-xl text-gray-700 flex-grow">
                            <span class="text-lg">{{ __('by') }}</span>
                            <a class="hover:underline" href="{{ route('author.show', $story->author) }}">
                                {{ $story->author->name }}
                            </a>
                        </h5>
                        <div class="ml-auto"><span class="font-semibold text-gray-500 text-sm">{{ __('História criada em') . ': ' }}</span> <span class="text-xs">{{ ($story->story_created_at ? $story->createdDate : '--') }}</span></div>
                        <div><span class="font-semibold text-gray-500 text-sm">{{ __('História atualizada em') . ': ' }}</span> <span class="text-xs">{{ ($story->story_updated_at ? $story->updatedDate.', '.$story->story_updated_at->diffForHumans() : '--') }}</span></div>
                    </div>
                </div>
                @if ($story['full_title'] !== null)
                    <hr>
                    <div>{{ $story['full_title'] }}</div>
                @endif
                <div class="py-2 bg-gray-50 border border-gray-200 flex-col md:flex-row flex justify-left items-center gap-6">
                    {{-- score --}}
                    <div class="ml-2 flex flex-row md:block items-center gap-2 md:gap-0 text-right
                                bg-gray-100 border border-gray-100 p-2 shadow-sm">
                        <div class="bg-blue-600 text-white text-sm h-full text-center">{{ __("Nota") }}</div>
                        <div class="text-center">
                            @if($story->score > 0)
                            <div class="text-4xl font-bold">{{ formatScore($story->score) }}</div>
                            @else
                            <div class="text-4xl font-bold" title="{{ __("Insuficient data") }}">--</div>
                            @endif
                        </div>
                        <div class="text-xs text-center">{{ formatInt($story->ratedCount()) }} usuários</div>
                    </div>

                    <div class="flex flex-col">
                        <div class="flex flex-row items-center gap-4">
                            <div class="flex flex-col items-start">
                                <div class="fandom">
                                    <div class="inline text-gray-700">
                                        Fandom:
                                    </div>
                                    <div class="inline text-gray-600 font-semibold">
                                        {{ $story->fandom ? __($story->fandom) : __('Unknown') }}
                                    </div>
                                </div>
                                <div class="type">
                                    <div class="inline text-gray-700">
                                        Tipo:
                                    </div>
                                    <div class="inline text-gray-600 font-semibold">
                                        {{ Str::ucfirst($story->type ?? __("Unknown")) }}
                                    </div>
                                </div>
                                <div class="status">
                                    <div class="text-lg font-semibold text-gray-600" style="letter-spacing: 0.04em;">
                                        {{ $story->story_status ? __('show.'.$story->story_status) : __("Unknown") }}
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col items-start text-base text-gray-700">
                                <div>{{ formatInt($story->readers()->count()) }} leitores</div>
                                <div>Qtd. de palavras: {{ $story->words ? formatInt($story->words)." palavras" : "--" }}</div>
                                <div>Nº de capítulos: {{ $story->chapters ? formatInt($story->chapters)." capítulos" : "--" }}</div>
                            </div>
                        </div>
                        {{-- links? --}}
                    </div>
                </div>
                <div class="flex items-start p-2" x-data="{ showAddTag: false }">
                    <div class="flex-grow flex">
                        <div class="taglist flex gap-2 flex-wrap">
                            <h4 class="mr-2">Tags:</h4>
                            @foreach ($story->tags as $tag)
                                <a href="#" x-data="{ tag:{{ $tag->id }}, rate: false }"
                                    x-on:click="rate = !rate" class="flex items-center border border-gray-200 bg-gray-100
                                    hover:bg-gray-200 px-2 rounded-lg cursor-pointer text-gray-600 hover:text-gray-700
                                    h-7 transition-colors"
                                ><span class="text-sm font-bold">{{ $tag->name }}</span><span class="ml-1 text-xs text-gray-800 font-sans">({{ $tag->tagged->tagged_score }})</span>
                                    <div x-show=rate class="mx-auto ml-1 text-lg flex">
                                        <form class="block" method="post" action="{{ route('story.tag.rateup', ['story' => $story->slug, 'tag' => $tag->id]) }}">
                                            @csrf
                                            {{-- <a class="hover:bg-green-400 transition-colors rounded-md" href="{{ route('story.tag.rateup', ['story' => $story->slug, 'tag' => $tag->id]) }}">👍</a> --}}
                                            <input type="submit" class="cursor-pointer bg-transparent hover:bg-green-400 focus:bg-green-400 transition-colors rounded-sm px-1" value="👍">
                                        </form>
                                        <form class="block" method="post" action="{{ route('story.tag.ratedown', ['story' => $story->slug, 'tag' => $tag->id]) }}">
                                            @csrf
                                            <input type="submit" class="cursor-pointer bg-transparent hover:bg-red-400 focus:bg-red-400 transition-colors rounded-sm px-1" value="👎">
                                            {{-- <a class="hover:bg-red-400 transition-colors rounded-md" href="{{ route('story.tag.ratedown', ['story' => $story->slug, 'tag' => $tag->id]) }}">👎</a> --}}
                                        </form>
                                    </div>
                                </a>
                                    {{-- "><span class="align-text-bottom">{{ $tag->name }}</span></div> --}}
                            {{-- @empty
                                <div class="text-sm font-bold">--</div> --}}
                            @endforeach
                            <div x-show="!showAddTag">
                                {{-- <a href="{{ route('story.tag', $story->slug) }}" title="Adicionar nova Tag"> --}}
                                {{-- <a href="#" onclick="document.getElementById('addtag')." title="Adicionar nova Tag"> --}}
                                {{-- <a @click="showAddTag = true" href="#" title="Adicionar nova Tag">
                                    <div class="font-bold border border-gray-200 bg-gray-100 px-2 rounded-lg">+</div></a> --}}
                                <button x-on:click="showAddTag=true" href="#" title="Adicionar nova Tag"
                                    class="font-bold border border-gray-200 bg-gray-100 hover:bg-gray-200 px-2 rounded-lg h-7">
                                    +
                                </button>
                            </div>
                        </div>
                    </div>
                    <div x-show="showAddTag" div="addtag" class="w-max shadow p-4 relative">
                        <span x-on:click="showAddTag=false" class="absolute top-0 right-2 cursor-pointer text-gray-600 hover:text-gray-500  mt-1.5 px-0.5 leading-3 rounded-sm text-sm">x</span>
                        <x-story.addtag :story="$story" :tags="$tags"></x-story.addtag>
                    </div>
                </div>
                <div class="bg-gray-50 border border-gray-200 p-2 pt-1">
                    <h3 class="text-gray-600 text-xl font-semibold">Sinopse:</h3>
                    @if ($story->description)
                    <div class="bg-white border shadow-inner border-gray-200 m-2 p-2">{{ $story->description }}</div>
                    @else
                    <div>
                        <span>Essa história ainda não tem uma sinopse.</span>
                        <a class="text-blue-600 hover:underline" href="{{ route('story.edit', $story) }}">Adicionar?</a>
                    </div>
                    @endif
                </div>
                <div class="p-2">
                    @if ($story->link)
                    <h4 class="">Onde ler:</h4>
                    <ul class="pl-1 list-inside list-disc">
                        <li><a class="text-blue-600 hover:underline" href="{{ $story->link }}">{{ $story->link }}</a></li>
                    </ul>
                    @else
                    <div>
                        <span>Não temos um link para essa história.</span>
                    </div>
                    @endif

                </div>
            </div>

            {{-- right collumn --}}
            <div class="w-3/12 hidden lg:flex flex-col gap-4">
                <div class="flex flex-row gap-4 ">
                    @foreach ([1,2] as $i)
                        <div class="border-2 border-dotted border-gray-200 text-gray-400 text-sm font-extralight h-24 w-full flex items-center justify-center">
                            <div class="mx-auto my-auto w-max transform-gpu rotate-6">Seu anúncio aqui</div>
                        </div>
                    @endforeach
                </div>
                <div class="flex flex-col items-stretch gap-4">
                    @foreach ([1,2] as $i)
                        <div class="border-2 border-dotted border-gray-200 text-gray-400 font-extralight h-24 flex items-center justify-center">
                            <div class="mx-auto my-auto w-max transform-gpu rotate-6">Seu anúncio aqui</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout-v2>
