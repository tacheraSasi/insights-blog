<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Insights') }} - 404 Not Found</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Icons -->
        <link rel="shortcut icon" href="{{ asset('assets/img/icon.png') }}" type="image/x-icon">

        <link rel="manifest" href="/manifest.json">
        <meta name="theme-color" content="#000000">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-neutral-900 antialiased bg-neutral-200 dark:bg-neutral-800">
        <div class="min-h-screen flex flex-col items-center justify-center px-6">
            <div class="text-center">
                <a href="/" class="flex items-center gap-3">
                    <x-application-logo class="w-16 h-16 fill-current text-neutral-500" />
                    <span class="text-3xl font-semibold text-neutral-800 dark:text-neutral-200">Insights</span>
                </a>
            </div>

            <x-card class="mt-8 w-full max-w-lg px-8 py-10 bg-white dark:bg-neutral-800 shadow-lg rounded-lg text-center">
                <h1 class="text-7xl font-extrabold text-red-600 dark:text-red-400 mx-auto">404</h1>
                <p class="text-xl text-neutral-600 dark:text-neutral-300 mt-3">
                    Oops! The page you're looking for doesn't exist.
                </p>

                <div class="mt-6 flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ url('/') }}"
                        class="px-6 py-3 bg-blue-600 dark:bg-blue-500 text-white text-lg font-medium rounded-md hover:bg-blue-700 dark:hover:bg-blue-600 transition-all">
                        Home
                    </a>
                    <a href="{{ url('/login') }}"
                        class="px-6 py-3 bg-green-600 dark:bg-green-500 text-white text-lg font-medium rounded-md hover:bg-green-700 dark:hover:bg-green-600 transition-all">
                        Login
                    </a>
                </div>

                <div class="mt-6 text-sm text-neutral-500 dark:text-neutral-400">
                    If you believe this is an error, please  
                    <a href="{{ url('/report') }}" class="text-blue-500 underline hover:text-blue-700 dark:hover:text-blue-400">
                        report it here.
                    </a>
                </div>
            </x-card>
        </div>
    </body>
</html>
