<x-app-layout>
    <x-slot name="header"><h2 class="font-display text-xl font-bold gradient-text">New message</h2></x-slot>
    <x-layouts.dashboard>
        <x-ui.glass-panel class="max-w-xl">
            <form method="POST" action="{{ route('messages.store') }}" class="space-y-5">
                @csrf
                <input type="hidden" name="lost_item_id" value="{{ $lostItemId }}">
                <input type="hidden" name="found_item_id" value="{{ $foundItemId }}">
                <x-ui.input-floating label="Receiver user ID" name="receiver_id" :value="old('receiver_id', $receiver?->id)" required />
                <x-input-error :messages="$errors->get('receiver_id')" />
                <x-ui.input-floating label="Subject" name="subject" :value="old('subject', 'Regarding your item report')" required />
                <div>
                    <label class="mb-2 block text-sm font-semibold">Message</label>
                    <textarea name="body" rows="5" class="input-float w-full min-h-[140px]" required>{{ old('body') }}</textarea>
                    <x-input-error :messages="$errors->get('body')" />
                </div>
                <x-ui.btn type="submit" variant="primary">Send securely</x-ui.btn>
            </form>
        </x-ui.glass-panel>
    </x-layouts.dashboard>
</x-app-layout>
