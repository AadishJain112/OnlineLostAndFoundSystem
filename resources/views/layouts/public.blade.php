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
</head>
<body class="min-h-full font-sans">
    <x-ui.background />
    <x-ui.toast-stack />

    @include('layouts.partials.nav-public')

    <main class="relative pt-20" data-page-content>
        @yield('content')
    </main>

    <footer class="relative mt-20 border-t border-white/20 py-12 dark:border-slate-800">
        <div class="mx-auto max-w-7xl px-4 text-center sm:px-6">
            <p class="text-sm text-slate-500 dark:text-slate-400">
                &copy; {{ date('Y') }} <span class="font-semibold gradient-text">{{ config('app.name') }}</span> — Reuniting people with what matters.
            </p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
