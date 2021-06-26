@if (session('status') && isset(session('status')['type']))
    <div x-data="{ show: true }" x-show="show" class="
        @switch(session('status')['type'])
            @case('success')
                bg-green-400 text-white
                @break
            @case('warning')
                bg-yellow-300 text-gray-700
                @break
            @default
                bg-gray-700 text-white
        @endswitch
        relative">
            <label
                class="w-full mb-2 flex items-start justify-between alert-banner
                font-bold shadow py-4 px-10"
                for="alert-banner">
                <div class="">
                    {{ session('status')['msg'] }}
                </div>
                <span x-on:click="show=false" class="w-6 inline-flex cursor-pointer justify-center" title="Close">x</span>
            </label>
        </div>
@endif
