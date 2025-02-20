{{-- resources/views/errors/404.blade.php --}}
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
    <body class="font-sans text-neutral-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-customGreenDark dark:bg-customGreenLight">
            <div>
                <a href="/" class="flex items-center gap-2">
                    <x-application-logo class="w-20 h-20 fill-current text-neutral-500" />
                    <span class="text-3xl font-semibold text-neutral-800 dark:text-neutral-200">Insights</span>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-6 bg-white dark:bg-neutral-800 shadow-md overflow-hidden sm:rounded-lg text-center">
                <h1 class="text-6xl font-extrabold text-blue-600 dark:text-blue-400">404</h1>
                <p class="text-xl text-neutral-700 dark:text-neutral-300 mt-4">
                    Oops! The page you're looking for doesn't exist.
                </p>
                
                <div class="mt-6 flex flex-col sm:flex-row sm:justify-center gap-4">
                    <a href="{{ url('/') }}"
                        class="px-6 py-3 bg-blue-600 dark:bg-blue-500 text-white rounded-md hover:bg-blue-700 dark:hover:bg-blue-600 transition">
                        Home
                    </a>
                    <a href="{{ url('/contact') }}"
                        class="px-6 py-3 bg-green-600 dark:bg-green-500 text-white rounded-md hover:bg-green-700 dark:hover:bg-green-600 transition">
                        Contact Support
                    </a>
                    <a href="{{ url('/faq') }}"
                        class="px-6 py-3 bg-purple-600 dark:bg-purple-500 text-white rounded-md hover:bg-purple-700 dark:hover:bg-purple-600 transition">
                        FAQ
                    </a>
                </div>

                <div class="mt-6 text-sm text-neutral-500 dark:text-neutral-400">
                    If you believe this is an error, please <a href="{{ url('/report') }}" class="text-blue-500 underline hover:text-blue-700 dark:hover:text-blue-400">
                        report it here
                    </a>.
                </div>
            </div>
        </div>
    </body>
</html>
