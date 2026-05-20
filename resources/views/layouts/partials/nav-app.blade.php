<nav x-data="mobileNav" class="fixed inset-x-0 top-0 z-50">
    <div class="mx-4 mt-4">
        <div class="glass-strong mx-auto flex max-w-7xl items-center justify-between rounded-2xl px-4 py-3 sm:px-6">
            <a href="{{ route('dashboard') }}" class="group flex items-center gap-2.5">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-brand-500 to-violet-600 text-lg shadow-glow-sm transition-transform group-hover:scale-105">🔍</div>
                <span class="font-display text-lg font-bold gradient-text hidden sm:inline">{{ config('app.name') }}</span>
            </a>

            <div class="hidden items-center gap-1 lg:flex">
                <a href="{{ route('dashboard') }}" class="nav-link-premium {{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('lost-items.index') }}" class="nav-link-premium {{ request()->routeIs('lost-items.*') ? 'active' : '' }}">Lost</a>
                <a href="{{ route('found-items.index') }}" class="nav-link-premium {{ request()->routeIs('found-items.*') ? 'active' : '' }}">Found</a>
                <a href="{{ route('my-reports.index') }}" class="nav-link-premium {{ request()->routeIs('my-reports.*') ? 'active' : '' }}">My Reports</a>
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="nav-link-premium {{ request()->routeIs('admin.*') ? 'active' : '' }}">Admin</a>
                @endif
            </div>

            <div class="flex items-center gap-2">
                <button type="button" x-data="themeToggle" @click="toggle()" class="glass flex h-10 w-10 items-center justify-center rounded-xl text-lg hover:scale-105 transition-transform" aria-label="Theme">
                    <span x-show="!dark">🌙</span>
                    <span x-show="dark" x-cloak>☀️</span>
                </button>

                @auth
                <div class="relative" x-data="notificationsDropdown">
                    <button @click="open = !open" class="glass relative flex h-10 w-10 items-center justify-center rounded-xl transition-transform hover:scale-105">
                        <span class="text-lg">🔔</span>
                        <span x-show="count > 0" x-text="count" class="absolute -right-1 -top-1 flex h-5 min-w-[20px] items-center justify-center rounded-full bg-gradient-to-r from-rose-500 to-red-500 px-1 text-[10px] font-bold text-white" data-notification-count>{{ auth()->user()->unreadNotifications()->count() }}</span>
                    </button>
                    <div x-show="open" @click.outside="open = false" x-transition class="glass-strong absolute right-0 mt-2 w-72 rounded-2xl p-4 shadow-glass-lg" x-cloak>
                        <p class="mb-2 text-sm font-semibold">Notifications</p>
                        <p class="text-xs text-slate-500 mb-3" x-text="count + ' unread'"></p>
                        <x-ui.btn variant="primary" :href="route('notifications.index')" class="w-full text-center text-xs">View all</x-ui.btn>
                    </div>
                </div>

                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="glass flex items-center gap-2 rounded-xl px-3 py-2 transition-transform hover:scale-105">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-br from-brand-500 to-violet-500 text-sm font-bold text-white">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <span class="hidden text-sm font-medium sm:inline">{{ auth()->user()->name }}</span>
                        <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" @click.outside="open = false" x-transition class="glass-strong absolute right-0 mt-2 w-52 rounded-2xl py-2 shadow-glass-lg" x-cloak>
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2.5 text-sm hover:bg-brand-500/10 transition-colors">Profile</a>
                        <a href="{{ route('messages.index') }}" class="block px-4 py-2.5 text-sm hover:bg-brand-500/10">Messages</a>
                        <a href="{{ route('bookmarks.index') }}" class="block px-4 py-2.5 text-sm hover:bg-brand-500/10">Bookmarks</a>
                        <hr class="my-2 border-slate-200/50 dark:border-slate-700">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2.5 text-left text-sm text-red-600 hover:bg-red-500/10">Log out</button>
                        </form>
                    </div>
                </div>
                @endauth

                <button @click="toggle()" class="glass flex h-10 w-10 items-center justify-center rounded-xl lg:hidden">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </div>

        <div x-show="open" x-transition x-cloak class="glass-strong mx-auto mt-2 max-w-7xl rounded-2xl p-4 lg:hidden">
            <div class="flex flex-col gap-1">
                <a @click="close()" href="{{ route('dashboard') }}" class="rounded-xl px-4 py-3 text-sm font-medium hover:bg-brand-500/10">Dashboard</a>
                <a @click="close()" href="{{ route('lost-items.index') }}" class="rounded-xl px-4 py-3 text-sm font-medium hover:bg-brand-500/10">Lost Items</a>
                <a @click="close()" href="{{ route('found-items.index') }}" class="rounded-xl px-4 py-3 text-sm font-medium hover:bg-brand-500/10">Found Items</a>
                <a @click="close()" href="{{ route('my-reports.index') }}" class="rounded-xl px-4 py-3 text-sm font-medium hover:bg-brand-500/10">My Reports</a>
                <a @click="close()" href="{{ route('notifications.index') }}" class="rounded-xl px-4 py-3 text-sm font-medium hover:bg-brand-500/10">Notifications</a>
            </div>
        </div>
    </div>
</nav>
