<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="min-h-full font-sans">
    <x-ui.background />
    <x-ui.toast-stack />

    @include('layouts.partials.nav-app')

    <div class="relative mx-auto max-w-7xl px-4 pb-16 pt-24 sm:px-6 lg:px-8" data-page-content>
        @isset($header)
            <header class="mb-8" data-aos="fade-down">
                <div class="glass rounded-2xl px-6 py-5">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main>
            {{ $slot }}
        </main>
    </div>

    @stack('scripts')
</body>
</html>
