<x-app-layout>
    <x-slot name="header"><h2 class="font-display text-xl font-bold gradient-text">Notifications</h2></x-slot>
    <x-layouts.dashboard>
        <form method="POST" action="{{ route('notifications.read-all') }}" class="mb-6">@csrf
            <x-ui.btn type="submit" variant="secondary">Mark all as read</x-ui.btn>
        </form>
        <div class="space-y-3">
            @forelse ($notifications as $notification)
                <div class="glass flex items-start gap-4 rounded-2xl p-5 transition-all hover:shadow-lift {{ $notification->read_at ? 'opacity-70' : 'ring-1 ring-brand-500/30' }}" data-aos="fade-up">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-brand-500 to-violet-500 text-lg">🔔</div>
                    <div class="flex-1">
                        <p class="text-sm font-medium">{{ $notification->data['message'] ?? 'New notification' }}</p>
                        <p class="mt-1 text-xs text-slate-500">{{ $notification->created_at->diffForHumans() }}</p>
                        @unless ($notification->read_at)
                            <form method="POST" action="{{ route('notifications.read', $notification->id) }}" class="mt-2">@csrf
                                <button type="submit" class="text-xs font-semibold text-brand-600 hover:underline">Mark read</button>
                            </form>
                        @endunless
                    </div>
                </div>
            @empty
                <x-empty-state title="All caught up!" message="No notifications right now." />
            @endforelse
        </div>
        <div class="mt-6">{{ $notifications->links() }}</div>
    </x-layouts.dashboard>
</x-app-layout>
