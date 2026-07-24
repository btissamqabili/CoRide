<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CoRide') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">

            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="py-6">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                    {{-- Message de succès --}}
                    @if(session('success'))
                        <div class="mb-4 rounded bg-green-100 border border-green-400 text-green-700 px-4 py-3">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Message d'erreur --}}
                    @if(session('error'))
                        <div class="mb-4 rounded bg-red-100 border border-red-400 text-red-700 px-4 py-3">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- Erreurs de validation --}}
                    @if($errors->any())
                        <div class="mb-4 rounded bg-red-100 border border-red-400 text-red-700 px-4 py-3">
                            <ul class="list-disc ml-5">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                   @yield('content')

                </div>
            </main>

        </div>
    </body>
</html>