<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'StoryChest') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body class="bg-gray-50 font-sans text-gray-900 antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')
        <main class="container mx-auto pt-4 min-h-full">
            <!-- Page Content -->
            <div class="bg-white border b-gray-400 shadow">
                <div class="card-header bg-gray-100 border-b border-gray-200 pt-4 px-4">
                    {{ $header }}
                </div>
                <div class="card-body p-4">

                    @if (session('status'));
                        @if (session('status')['type'] == 'success');
                            <div class="alert-banner relative">
                                <label
                                    class="w-full mb-2 flex items-start justify-between bg-green-400 text-white font-bold shadow py-4 px-10"
                                    for="success-banner">
                                    {{-- <label class=" transition-all cursor-pointer flex items-start justify-between w-full bg-green-400 text-white font-bold shadow py-4 px-10 min-h-full" for="success-banner" title="Close"></label> --}}
                                    <div class="">
                                        {{-- Sucesso! --}}
                                        {{ session('status')['msg'] }}
                                        {{-- <span class="w-6 inline-flex justify-center" title="Close">x</span> --}}
                                    </div>
                                </label>
                            </div>
                        @endif
                    @endif
                    <x-auth-validation-errors :errors="$errors" class="container shadow mb-2 items-start justify-between
                    bg-red-500 text-white font-bold py-6 px-10 " />
                    {{ $slot }}
                </div>
            </div>
        </main>
    </div>
</body>

</html>
