<nav x-data="mobileNav" class="fixed inset-x-0 top-0 z-50 transition-all duration-300">
    <div class="mx-4 mt-4">
        <div class="glass-strong mx-auto flex max-w-7xl items-center justify-between rounded-2xl px-4 py-3 sm:px-6">
            <a href="{{ route('home') }}" class="group flex items-center gap-2.5">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-brand-500 to-violet-600 text-lg shadow-glow-sm transition-transform group-hover:scale-105">🔍</div>
                <span class="font-display text-lg font-bold gradient-text hidden sm:inline">{{ config('app.name') }}</span>
            </a>

            <div class="hidden items-center gap-1 md:flex">
                <a href="{{ route('lost-items.index') }}" class="nav-link-premium {{ request()->routeIs('lost-items.*') ? 'active' : '' }}">Lost</a>
                <a href="{{ route('found-items.index') }}" class="nav-link-premium {{ request()->routeIs('found-items.*') ? 'active' : '' }}">Found</a>
                <a href="{{ route('about') }}" class="nav-link-premium {{ request()->routeIs('about') ? 'active' : '' }}">About</a>
                <a href="{{ route('contact') }}" class="nav-link-premium {{ request()->routeIs('contact*') ? 'active' : '' }}">Contact</a>
            </div>

            <div class="flex items-center gap-2">
                <button type="button" x-data="themeToggle" @click="toggle()" class="glass flex h-10 w-10 items-center justify-center rounded-xl text-lg transition-transform hover:scale-105" aria-label="Toggle theme">
                    <span x-show="!dark">🌙</span>
                    <span x-show="dark" x-cloak>☀️</span>
                </button>
                @auth
                    <x-ui.btn variant="primary" :href="route('dashboard')" class="hidden sm:inline-flex">Dashboard</x-ui.btn>
                @else
                    <x-ui.btn variant="ghost" :href="route('login')" class="hidden sm:inline-flex">Log in</x-ui.btn>
                    <x-ui.btn variant="primary" :href="route('register')">Get started</x-ui.btn>
                @endauth
                <button @click="toggle()" class="glass flex h-10 w-10 items-center justify-center rounded-xl md:hidden" aria-label="Menu">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </div>

        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-cloak class="glass-strong mx-auto mt-2 max-w-7xl rounded-2xl p-4 md:hidden">
            <div class="flex flex-col gap-1">
                <a @click="close()" href="{{ route('lost-items.index') }}" class="rounded-xl px-4 py-3 text-sm font-medium hover:bg-brand-500/10">Lost Items</a>
                <a @click="close()" href="{{ route('found-items.index') }}" class="rounded-xl px-4 py-3 text-sm font-medium hover:bg-brand-500/10">Found Items</a>
                <a @click="close()" href="{{ route('about') }}" class="rounded-xl px-4 py-3 text-sm font-medium hover:bg-brand-500/10">About</a>
                <a @click="close()" href="{{ route('contact') }}" class="rounded-xl px-4 py-3 text-sm font-medium hover:bg-brand-500/10">Contact</a>
            </div>
        </div>
    </div>
</nav>
