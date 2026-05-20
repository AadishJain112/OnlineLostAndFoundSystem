@extends('layouts.public')
@section('title', 'Contact')
@section('content')
<div class="mx-auto max-w-xl px-4 py-16 sm:px-6">
    <x-ui.glass-panel>
        <x-ui.page-header title="Get in touch" subtitle="We'd love to hear from you." gradient />
        <form method="POST" action="{{ route('contact.submit') }}" class="mt-6 space-y-5">
            @csrf
            <x-ui.input-floating label="Name" name="name" :value="old('name')" required />
            <x-input-error :messages="$errors->get('name')" />
            <x-ui.input-floating label="Email" name="email" type="email" :value="old('email')" required />
            <x-input-error :messages="$errors->get('email')" />
            <div>
                <label class="mb-2 block text-sm font-semibold">Message</label>
                <textarea name="message" rows="5" class="input-float w-full min-h-[120px]" required>{{ old('message') }}</textarea>
                <x-input-error :messages="$errors->get('message')" />
            </div>
            <x-ui.btn type="submit" variant="primary" class="w-full justify-center">Send message</x-ui.btn>
        </form>
    </x-ui.glass-panel>
</div>
@endsection
