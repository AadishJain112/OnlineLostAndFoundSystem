<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display text-xl font-bold gradient-text">Dashboard</h2>
    </x-slot>

    <x-layouts.dashboard>
        <x-ui.page-header
            title="Welcome back, {{ auth()->user()->name }}"
            subtitle="Here's what's happening with your lost & found reports."
            gradient
        />

        <div class="mb-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <x-ui.stat-card label="Lost reports" :value="$lostCount" icon="🔴" color="amber" />
            <x-ui.stat-card label="Found reports" :value="$foundCount" icon="🟢" color="emerald" />
            <x-ui.stat-card label="Notifications" :value="$unreadNotifications" icon="🔔" color="violet" />
            <x-ui.stat-card label="Messages" :value="$unreadMessages" icon="💬" color="brand" />
        </div>

        <div class="mb-8 grid gap-6 lg:grid-cols-2">
            <x-ui.glass-panel>
                <h3 class="mb-4 font-display font-bold">Reports overview</h3>
                <div class="h-64">
                    <canvas
                        data-chart="doughnut"
                        data-labels='["Lost","Found"]'
                        data-values='[{{ $lostCount }},{{ $foundCount }}]'
                        data-colors='["#f59e0b","#10b981"]'
                    ></canvas>
                </div>
            </x-ui.glass-panel>
            <x-ui.glass-panel>
                <h3 class="mb-4 font-display font-bold">Activity</h3>
                <div class="h-64">
                    <canvas
                        data-chart="bar"
                        data-labels='["Lost","Found","Matches","Msgs"]'
                        data-values='[{{ $lostCount }},{{ $foundCount }},{{ $matches->count() }},{{ $unreadMessages }}]'
                        data-label="Your activity"
                    ></canvas>
                </div>
            </x-ui.glass-panel>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <x-ui.glass-panel class="lg:col-span-2">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="font-display font-bold">Potential matches</h3>
                    <span class="rounded-full bg-brand-500/10 px-3 py-1 text-xs font-semibold text-brand-600">{{ $matches->count() }} active</span>
                </div>
                <div class="space-y-3">
                    @forelse ($matches as $match)
                        <div class="flex items-center gap-4 rounded-xl border border-brand-500/10 bg-brand-500/5 p-4 transition-all hover:border-brand-500/30" data-aos="fade-up">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-brand-500 to-violet-500 text-sm font-bold text-white">
                                {{ $match->match_score }}%
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-semibold">{{ $match->lostItem->title }}</p>
                                <p class="truncate text-xs text-slate-500">↔ {{ $match->foundItem->title }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="py-8 text-center text-sm text-slate-500">No matches yet — keep your reports updated!</p>
                    @endforelse
                </div>
            </x-ui.glass-panel>

            <x-ui.glass-panel>
                <h3 class="mb-4 font-display font-bold">Quick actions</h3>
                <div class="flex flex-col gap-3">
                    <x-ui.btn variant="primary" :href="route('lost-items.create')" class="w-full justify-center">+ Report lost</x-ui.btn>
                    <x-ui.btn variant="success" :href="route('found-items.create')" class="w-full justify-center">+ Report found</x-ui.btn>
                    <x-ui.btn variant="secondary" :href="route('notifications.index')" class="w-full justify-center">Notifications</x-ui.btn>
                </div>

                <h4 class="mt-8 mb-3 text-xs font-bold uppercase tracking-wider text-slate-400">Timeline</h4>
                <div class="space-y-4 border-l-2 border-brand-500/20 pl-4">
                    @foreach ($recentLost->take(3) as $item)
                        <div class="relative">
                            <span class="absolute -left-[21px] top-1 h-2.5 w-2.5 rounded-full bg-amber-500"></span>
                            <p class="text-xs text-slate-500">{{ $item->created_at->diffForHumans() }}</p>
                            <p class="text-sm font-medium truncate">Lost: {{ $item->title }}</p>
                        </div>
                    @endforeach
                    @foreach ($recentFound->take(2) as $item)
                        <div class="relative">
                            <span class="absolute -left-[21px] top-1 h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                            <p class="text-xs text-slate-500">{{ $item->created_at->diffForHumans() }}</p>
                            <p class="text-sm font-medium truncate">Found: {{ $item->title }}</p>
                        </div>
                    @endforeach
                </div>
            </x-ui.glass-panel>
        </div>
    </x-layouts.dashboard>
</x-app-layout>
