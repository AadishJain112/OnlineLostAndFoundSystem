<x-app-layout>
    <x-slot name="header"><h2 class="font-display text-xl font-bold gradient-text">Admin Analytics</h2></x-slot>
    <x-layouts.dashboard>
        <x-ui.page-header title="Admin control center" subtitle="Platform overview and moderation tools." gradient />

        <div class="mb-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <x-ui.stat-card label="Users" :value="$stats['users']" icon="👥" color="brand" />
            <x-ui.stat-card label="Lost reports" :value="$stats['lost']" icon="🔴" color="amber" />
            <x-ui.stat-card label="Found reports" :value="$stats['found']" icon="🟢" color="emerald" />
            <x-ui.stat-card label="Matches" :value="$stats['matches']" icon="✨" color="violet" />
        </div>

        <div class="mb-8 grid gap-6 lg:grid-cols-2">
            <x-ui.glass-panel>
                <h3 class="mb-4 font-display font-bold">Platform stats</h3>
                <div class="h-72">
                    <canvas data-chart="bar"
                        data-labels='["Users","Lost","Found","Matches","Messages","Comments"]'
                        data-values='[{{ $stats['users'] }},{{ $stats['lost'] }},{{ $stats['found'] }},{{ $stats['matches'] }},{{ $stats['messages'] }},{{ $stats['comments'] }}]'>
                    </canvas>
                </div>
            </x-ui.glass-panel>
            <x-ui.glass-panel>
                <h3 class="mb-4 font-display font-bold">Report distribution</h3>
                <div class="h-72">
                    <canvas data-chart="doughnut"
                        data-labels='["Lost","Found"]'
                        data-values='[{{ $stats['lost'] }},{{ $stats['found'] }}]'
                        data-colors='["#f59e0b","#10b981"]'>
                    </canvas>
                </div>
            </x-ui.glass-panel>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <x-ui.glass-panel>
                <h3 class="mb-4 font-display font-bold">Recent users</h3>
                @foreach ($recentUsers as $user)
                    <div class="flex items-center gap-3 border-b border-slate-200/50 py-3 last:border-0 dark:border-slate-700">
                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gradient-to-br from-brand-500 to-violet-500 text-xs font-bold text-white">{{ strtoupper(substr($user->name,0,1)) }}</div>
                        <div><p class="text-sm font-semibold">{{ $user->name }}</p><p class="text-xs text-slate-500">{{ $user->email }}</p></div>
                    </div>
                @endforeach
            </x-ui.glass-panel>
            <x-ui.glass-panel>
                <h3 class="mb-4 font-display font-bold">Recent reports</h3>
                @foreach ($recentLost->merge($recentFound)->take(6) as $item)
                    <p class="py-2 text-sm border-b border-slate-200/50 dark:border-slate-700">{{ $item->title }}</p>
                @endforeach
            </x-ui.glass-panel>
        </div>
    </x-layouts.dashboard>
</x-app-layout>
