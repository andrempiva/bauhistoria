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
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <div class="max-w-7xl mx-auto py-6 px-0 sm:px-6 lg:px-8">
                    <div class="shadow bg-white py-6 px-10 min-h-full">
                        @if (session('status'))
                            @if (session('status')['type'] == 'success')
                                {{-- <div class="container flex justify-between bg-green-400 text-white font-bold shadow py-4 px-10 min-h-full"> --}}
                                <div class="alert-banner relative">
                                    <label class="w-full mb-2 flex items-start justify-between bg-green-400 text-white font-bold shadow py-4 px-10" for="success-banner">
                                    {{-- <label class=" transition-all cursor-pointer flex items-start justify-between w-full bg-green-400 text-white font-bold shadow py-4 px-10 min-h-full" for="success-banner" title="Close"> --}}
                                        <div class="">
                                            {{-- Sucesso! --}}
                                            {{ session('status')['msg'] }}
                                            {{-- <span class="w-6 inline-flex justify-center" title="Close">x</span> --}}
                                        </div>
                                    </label>
                                </div>
                            @endif
                        @endif
                        <x-auth-validation-errors :errors="$errors"
                            class="container shadow mb-2 items-start justify-between bg-red-500 text-white font-bold py-6 px-10 "/>
                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>
