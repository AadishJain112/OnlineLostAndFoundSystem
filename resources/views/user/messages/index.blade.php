<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-display text-xl font-bold gradient-text">Messages</h2>
            <x-ui.btn variant="primary" :href="route('messages.create')">New message</x-ui.btn>
        </div>
    </x-slot>
    <x-layouts.dashboard>
        <div class="grid gap-6 lg:grid-cols-2">
            <x-ui.glass-panel>
                <h3 class="mb-4 flex items-center gap-2 font-display font-bold">
                    <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse-soft"></span> Inbox
                </h3>
                <div class="space-y-2 max-h-[480px] overflow-y-auto">
                    @forelse ($inbox as $message)
                        <a href="{{ route('messages.show', $message) }}" class="group flex items-start gap-3 rounded-xl p-4 transition-all hover:bg-brand-500/10 {{ !$message->read_at ? 'bg-brand-500/5 ring-1 ring-brand-500/20' : 'bg-white/30 dark:bg-slate-800/30' }}">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-brand-500 to-violet-500 text-sm font-bold text-white">{{ strtoupper(substr($message->sender->name,0,1)) }}</div>
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-semibold group-hover:text-brand-600">{{ $message->subject }}</p>
                                <p class="text-xs text-slate-500">From {{ $message->sender->name }} · {{ $message->created_at->diffForHumans() }}</p>
                            </div>
                        </a>
                    @empty
                        <p class="py-12 text-center text-sm text-slate-500">No messages yet</p>
                    @endforelse
                </div>
                <div class="mt-4">{{ $inbox->links() }}</div>
            </x-ui.glass-panel>

            <x-ui.glass-panel>
                <h3 class="mb-4 font-display font-bold">Sent</h3>
                <div class="space-y-2 max-h-[480px] overflow-y-auto">
                    @foreach ($sent as $message)
                        <a href="{{ route('messages.show', $message) }}" class="block rounded-xl bg-white/30 p-4 transition-all hover:bg-emerald-500/10 dark:bg-slate-800/30">
                            <p class="text-sm font-semibold">{{ $message->subject }}</p>
                            <p class="text-xs text-slate-500">To {{ $message->receiver->name }}</p>
                        </a>
                    @endforeach
                </div>
            </x-ui.glass-panel>
        </div>
    </x-layouts.dashboard>
</x-app-layout>
