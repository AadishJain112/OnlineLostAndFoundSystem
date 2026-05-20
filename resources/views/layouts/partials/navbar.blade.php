<nav class="border-b border-slate-200 bg-white/90 backdrop-blur dark:border-slate-800 dark:bg-slate-900/90">
    <div class="max-w-7xl mx-auto flex h-16 items-center justify-between px-4 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" class="text-lg font-bold text-indigo-600 dark:text-indigo-400">
            {{ config('app.name') }}
        </a>
        <div class="hidden items-center gap-6 text-sm font-medium md:flex">
            <a href="{{ route('lost-items.index') }}" class="hover:text-indigo-600">Lost Items</a>
            <a href="{{ route('found-items.index') }}" class="hover:text-indigo-600">Found Items</a>
            <a href="{{ route('about') }}" class="hover:text-indigo-600">About</a>
            <a href="{{ route('contact') }}" class="hover:text-indigo-600">Contact</a>
        </div>
        <div class="flex items-center gap-3">
            <button type="button" data-theme-toggle class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs dark:border-slate-700">Theme</button>
            @auth
                <a href="{{ route('dashboard') }}" class="rounded-lg bg-indigo-600 px-3 py-2 text-sm text-white hover:bg-indigo-500">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="text-sm hover:text-indigo-600">Log in</a>
                <a href="{{ route('register') }}" class="rounded-lg bg-indigo-600 px-3 py-2 text-sm text-white hover:bg-indigo-500">Register</a>
            @endauth
        </div>
    </div>
</nav>
