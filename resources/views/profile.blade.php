<x-app-layout-v2>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <x-slot name="slot">
        <div class="lg:flex">
            <div class="w-3/12">
                <div class="font-serif text-4xl font-semibold text-gray-700 "
                >{{ $user->name }}</div>
            </div>
            <div class="w-9/12">
                <div class="stories">
                    <h3 class="font-bold text-xl">Histórias listadas</h3>
                    <table class="border border-blue-200 divide-y-2 divide-gray-500">
                        <thead class="bg-blue-900 text-white text-sm border-0 border-b border-blue-600">
                            <tr>
                                <th class="border text-left py-2 px-4">
                                    {{ __('Cover') }}
                                </th>
                                <th class="border text-left py-2 px-4">
                                    {{ __('Story') }}
                                </th>
                                <th class="border text-left py-2 px-4">
                                    {{ __('Fandom') }}
                                </th>
                                <th class="border text-left py-2 px-4">
                                    {{ __('Status') }}
                                </th>
                                <th class="border text-left py-2 px-4">
                                    {{ __('Rating') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        {{-- @foreach (auth()->user()->storiesForListing as $story) --}}
                        @foreach ($user->stories as $story)
                            <tr class="items-center gap-6 my-4 border">
                                <td class="border py-1 px-4 align-middle storyCover">
                                    <a href="{{ route('story.show', $story->slug) }}"
                                        @if($story['full_title'])
                                        title="{{ $story['full_title'] }}"
                                        @endif
                                    ><img class="max-h-16" style="max-width: 64px;"
                                     src="{{ $story->cover ? asset('storage/img/'. $story->cover) : asset("img/60x60.png") }}" alt=""></a>
                                </td>
                                <td class="border py-1 px-4 align-middle name">
                                    <div class="font-medium text-lg"><a href="{{ route('story.show', $story) }}"
                                        @if($story->full_title)
                                        title="{{ $story->full_title }}"
                                        @endif
                                    >{{ $story['title'] }}</a></div>
                                    <div>{{ __('by') }} <a href="{{ route('author.show', $story['author']['slug']) }}" class="text-gray-700"> {{ $story['author']->name }}</a></div>
                                </td>
                                <td class="border py-1 px-4 align-middle fandom">
                                    {{ __( $story['fandom'] ) }}
                                </td>
                                <td class="border py-4 px-4 align-middle my_status">
                                    {{ __( $story['story_status'] ) }}
                                </td>
                                <td class="rating border py-4 px-4 align-middle text-3xl font-bold text-center font-serif">
                                    @if($story['rating'])
                                        {{ $story['rating'] }}
                                    @else
                                        <span class="font-normal text-lg text-gray-400">NA</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @if(auth()->check() && auth()->id() === $user->id)
        <div>
            <form action="{{ route('profile.update') }}" method="post">
            <div class="profile grid grid-cols-3 mb-4">
                    @csrf
                    <div class="form-item ml-4 mb-4">
                        <x-label for="name" :value="__('Name')"/>
                        <x-input class="block mt-1 w-full" name="name" required
                            value="{{ auth()->user()->name }}"/>
                    </div>
                    <div class="form-item ml-4 mb-4">
                        <x-label for="email" :value="__('Email')"/>
                        <x-input class="block mt-1 w-full" name="email" required
                            value="{{ auth()->user()->email }}"/>
                    </div>
                    <x-button class="w-min">
                        {{ __('Update Profile') }}
                    </x-button>
                </div>
            </form>
        </div>
        @endif
    </x-slot>
</x-app-layout-v2>
