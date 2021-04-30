@props(['errors'])

@if ($errors->any())
    <div {{ $attributes }}>
        <div class="flex justify-between">
            <div class="font-bold">
                {{ __('Whoops! Something went wrong.') }}
            </div>
            <button type="button" class="close" data-dismiss="alert">x</button>
        </div>

        <ul class="mt-3 list-disc list-inside text-sm dark:text-white">
            @foreach ($errors->all() as $error)
            {{-- <li>Error aaaaaaaaaaaaaaaaaaaaaaaaa</li>
            <li>Error aaaaaaaaaaaaaaaaaaaaaaaaa</li>
            <li>Error aaaaaaaaaaaaaaaaaaaaaaaaa</li> --}}
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
