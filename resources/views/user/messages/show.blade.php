<x-app-layout>
    <x-slot name="header"><h2 class="font-display text-xl font-bold">{{ $message->subject }}</h2></x-slot>
    <x-layouts.dashboard>
        <x-ui.glass-panel class="max-w-2xl">
            <div class="mb-6 flex items-center gap-3 border-b border-slate-200/50 pb-4 dark:border-slate-700">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-brand-500 to-violet-500 font-bold text-white">
                    {{ strtoupper(substr($message->sender->name, 0, 1)) }}
                </div>
                <div>
                    <p class="font-semibold">{{ $message->sender->name }} → {{ $message->receiver->name }}</p>
                    <p class="text-xs text-slate-500">{{ $message->created_at->format('M d, Y H:i') }} · <span class="rounded-full bg-brand-500/10 px-2 py-0.5 text-brand-600">{{ $message->status->label() }}</span></p>
                </div>
            </div>

            <div class="space-y-4" x-data="{ typing: true }" x-init="setTimeout(() => typing = false, 1200)">
                <div class="chat-in max-w-[85%]" data-aos="fade-up">
                    <p class="text-sm">{{ nl2br(e($message->body)) }}</p>
                </div>
                <div x-show="typing" x-transition class="flex items-center gap-2 text-xs text-slate-500">
                    <span class="flex gap-1">
                        <span class="h-2 w-2 rounded-full bg-slate-400 animate-bounce"></span>
                        <span class="h-2 w-2 rounded-full bg-slate-400 animate-bounce" style="animation-delay:0.1s"></span>
                        <span class="h-2 w-2 rounded-full bg-slate-400 animate-bounce" style="animation-delay:0.2s"></span>
                    </span>
                    Message delivered securely
                </div>
            </div>

            @if ($message->receiver_id === auth()->id() && $message->status->value === 'pending')
                <div class="mt-8 flex gap-3 border-t border-slate-200/50 pt-6 dark:border-slate-700">
                    <form method="POST" action="{{ route('messages.status', $message) }}">@csrf @method('PATCH')
                        <input type="hidden" name="status" value="accepted">
                        <x-ui.btn type="submit" variant="success">Accept contact</x-ui.btn>
                    </form>
                    <form method="POST" action="{{ route('messages.status', $message) }}">@csrf @method('PATCH')
                        <input type="hidden" name="status" value="rejected">
                        <x-ui.btn type="submit" variant="danger">Reject</x-ui.btn>
                    </form>
                </div>
            @endif
        </x-ui.glass-panel>
    </x-layouts.dashboard>
</x-app-layout>
