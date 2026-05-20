<aside class="w-full shrink-0 lg:w-64" data-aos="fade-right">
    <div class="glass-strong sticky top-28 rounded-2xl p-4">
        <p class="mb-4 px-3 text-xs font-bold uppercase tracking-wider text-slate-400">Menu</p>
        <nav class="space-y-1">
            @php
                $links = [
                    ['route' => 'dashboard', 'label' => 'Dashboard', 'icon' => '📊', 'pattern' => 'dashboard'],
                    ['route' => 'my-reports.index', 'label' => 'My Reports', 'icon' => '📋', 'pattern' => 'my-reports.*'],
                    ['route' => 'lost-items.create', 'label' => 'Report Lost', 'icon' => '🔴', 'pattern' => 'lost-items.create'],
                    ['route' => 'found-items.create', 'label' => 'Report Found', 'icon' => '🟢', 'pattern' => 'found-items.create'],
                    ['route' => 'notifications.index', 'label' => 'Notifications', 'icon' => '🔔', 'pattern' => 'notifications.*'],
                    ['route' => 'messages.index', 'label' => 'Messages', 'icon' => '💬', 'pattern' => 'messages.*'],
                    ['route' => 'bookmarks.index', 'label' => 'Bookmarks', 'icon' => '⭐', 'pattern' => 'bookmarks.*'],
                    ['route' => 'profile.edit', 'label' => 'Settings', 'icon' => '⚙️', 'pattern' => 'profile.*'],
                ];
                if (auth()->user()->isAdmin()) {
                    $links[] = ['route' => 'admin.dashboard', 'label' => 'Admin Panel', 'icon' => '🛡️', 'pattern' => 'admin.*'];
                }
            @endphp
            @foreach ($links as $link)
                <a href="{{ route($link['route']) }}"
                   class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200
                   {{ request()->routeIs($link['pattern']) ? 'bg-gradient-to-r from-brand-500/20 to-violet-500/10 text-brand-700 dark:text-brand-300 shadow-glow-sm' : 'text-slate-600 hover:bg-white/60 hover:pl-4 dark:text-slate-300 dark:hover:bg-slate-800/60' }}">
                    <span class="text-lg transition-transform group-hover:scale-110">{{ $link['icon'] }}</span>
                    {{ $link['label'] }}
                </a>
            @endforeach
        </nav>
    </div>
</aside>
