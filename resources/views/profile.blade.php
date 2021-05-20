<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <x-slot name="slot">
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
        <hr>
        <div class="stories">
            <h3 class="font-bold text-xl">Stories listed</h3>
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
                @foreach (auth()->user()->storiesForListing as $story)
                    <tr class="items-center gap-6 my-4 border">
                        <td class="border py-1 px-4 align-middle storyCover">
                            <img src="https://via.placeholder.com/60x60" alt="">
                        </td>
                        <td class="border py-1 px-4 align-middle name">
                            <div class="font-medium text-lg">{{ $story['title'] }}</div>
                            <div>{{ __('by') }} <a href="{{ route('author.show', $story['author']['slug']) }}" class="italic text-gray-700"> {{ $story['author']->name }}</a></div>
                        </td>
                        <td class="border py-1 px-4 align-middle fandom">
                            {{ Str::ucfirst( $story['fandom'] ) }}
                        </td>
                        <td class="border py-4 px-4 align-middle my_status">
                            {{ Str::ucfirst( $story['story_status'] ) }}
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
    </x-slot>
</x-app-layout>
