@extends('layouts.public')
@section('title', 'About')
@section('content')
<div class="mx-auto max-w-3xl px-4 py-16 sm:px-6">
    <x-ui.glass-panel>
        <x-ui.page-header title="About our platform" subtitle="Reuniting communities with what matters most." gradient />
        <div class="prose prose-slate dark:prose-invert max-w-none space-y-4 text-slate-600 dark:text-slate-400" data-aos="fade-up">
            <p>The Online Lost and Found Reporting System helps communities report, search, and recover lost belongings through a secure, modern platform.</p>
            <ul class="space-y-2">
                <li class="flex gap-2"><span class="text-brand-500">✓</span> Smart matching engine</li>
                <li class="flex gap-2"><span class="text-brand-500">✓</span> Secure in-platform messaging</li>
                <li class="flex gap-2"><span class="text-brand-500">✓</span> Image uploads & verification QR</li>
                <li class="flex gap-2"><span class="text-brand-500">✓</span> Admin moderation tools</li>
            </ul>
        </div>
    </x-ui.glass-panel>
</div>
@endsection
