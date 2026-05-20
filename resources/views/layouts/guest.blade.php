<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full font-sans">
    <x-ui.background />
    <x-ui.toast-stack />

    <div class="flex min-h-screen flex-col items-center justify-center px-4 py-12" data-page-content>
        <a href="{{ route('home') }}" class="mb-8 flex items-center gap-3 transition-transform hover:scale-105" data-aos="fade-down">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-brand-500 to-violet-600 text-xl text-white shadow-glow">🔍</div>
            <span class="font-display text-xl font-bold gradient-text">{{ config('app.name') }}</span>
        </a>

        <div class="glass-strong w-full max-w-md rounded-3xl p-8 shadow-glass-lg" data-aos="zoom-in" data-aos-duration="600">
            {{ $slot }}
        </div>

        <p class="mt-8 text-center text-sm text-slate-500">
            <a href="{{ route('home') }}" class="hover:text-brand-600 transition-colors">← Back to home</a>
        </p>
    </div>
</body>
</html>
