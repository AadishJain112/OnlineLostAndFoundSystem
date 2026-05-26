<x-app-layout>
    <x-slot name="header"><h2 class="font-display text-xl font-bold gradient-text">New message</h2></x-slot>
    <x-layouts.dashboard>
        <x-ui.glass-panel class="max-w-xl">
            <form method="POST" action="{{ route('messages.store') }}" class="space-y-5">
                @csrf
                {{-- receiver_id and item IDs are passed as hidden fields.
                     They are pre-filled automatically when you click
                     "Contact reporter" on any lost/found item page.
                     The user never needs to type an ID manually. --}}
                <input type="hidden" name="receiver_id" value="{{ $receiver?->id }}">
                <input type="hidden" name="lost_item_id" value="{{ $lostItemId }}">
                <input type="hidden" name="found_item_id" value="{{ $foundItemId }}">

                {{-- Show who you are sending to, read-only --}}
                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-600 dark:text-slate-400">Sending to</label>
                    @if ($receiver)
                        <div class="flex items-center gap-3 rounded-xl border border-white/30 bg-white/40 px-4 py-3 dark:bg-slate-800/40">
                            <div class="flex h-9 w-9 items-center justify-center rounded-full bg-brand-500 text-sm font-bold text-white">
                                {{ strtoupper(substr($receiver->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-slate-800 dark:text-white">{{ $receiver->name }}</p>
                                <p class="text-xs text-slate-500">Item reporter</p>
                            </div>
                        </div>
                    @else
                        <div class="rounded-xl border border-red-300 bg-red-50 px-4 py-3 text-sm text-red-600 dark:bg-red-900/20 dark:text-red-400">
                            ⚠️ No recipient found. Please go to an item page and click <strong>"Contact reporter"</strong>.
                        </div>
                    @endif
                    <x-input-error :messages="$errors->get('receiver_id')" />
                </div>

                <x-ui.input-floating label="Subject" name="subject" :value="old('subject', 'Regarding your item report')" required />

                <div>
                    <label class="mb-2 block text-sm font-semibold">Message</label>
                    <textarea name="body" rows="5" class="input-float w-full min-h-[140px]" required>{{ old('body') }}</textarea>
                    <x-input-error :messages="$errors->get('body')" />
                </div>

                @if($receiver)
                <x-ui.btn type="submit" variant="primary">Send securely</x-ui.btn>
                @else
                <x-ui.btn type="submit" variant="primary" disabled>Send securely</x-ui.btn>
                @endif
            </form>
        </x-ui.glass-panel>
    </x-layouts.dashboard>
</x-app-layout>
