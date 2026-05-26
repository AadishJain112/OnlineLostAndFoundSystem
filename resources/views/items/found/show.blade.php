@extends('layouts.public')
@section('title', $item->title)
@section('content')
<div class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8">
    <div class="grid gap-8 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-6">
            <div data-aos="fade-up">
                <div class="mb-4 flex flex-wrap items-center gap-3">
                    <h1 class="font-display text-3xl font-bold">{{ $item->title }}</h1>
                    <x-status-badge :status="$item->status" />
                </div>
                <p class="text-lg text-slate-600 dark:text-slate-400">{{ $item->description }}</p>
            </div>
            <x-ui.glass-panel>
                <dl class="grid gap-4 sm:grid-cols-2 text-sm">
                    <div><dt class="font-semibold text-slate-500">Category</dt><dd class="mt-1">{{ $item->category->name }}</dd></div>
                    <div><dt class="font-semibold text-slate-500">Date found</dt><dd class="mt-1">{{ $item->date_found->format('M d, Y') }}</dd></div>
                    <div class="sm:col-span-2"><dt class="font-semibold text-slate-500">Location</dt><dd class="mt-1">📍 {{ $item->location }}</dd></div>
                </dl>
            </x-ui.glass-panel>
            @if ($item->images->count())
                <div class="grid gap-4 sm:grid-cols-2">
                    @foreach ($item->images as $image)
                        <div class="overflow-hidden rounded-2xl glass group" data-tilt>
                            <img src="{{ $image->url() }}" class="aspect-video w-full object-cover group-hover:scale-105 transition-transform duration-700">
                        </div>
                    @endforeach
                </div>
            @endif
            @auth
                <x-ui.glass-panel>
                    <h2 class="font-display mb-4 font-bold">Comments</h2>
                    @foreach ($item->comments as $comment)
                        <div class="mb-3 rounded-xl bg-white/50 p-3 text-sm dark:bg-slate-800/50">
                            <p class="font-semibold">{{ $comment->user->name }}</p>
                            <p class="text-slate-600 dark:text-slate-400">{{ $comment->body }}</p>
                        </div>
                    @endforeach
                    <form method="POST" action="{{ route('found-items.comments.store', $item) }}" class="mt-4">
                        @csrf
                        <textarea name="body" rows="3" class="input-float w-full" required></textarea>
                        <x-ui.btn type="submit" variant="primary" class="mt-3">Post comment</x-ui.btn>
                    </form>
                </x-ui.glass-panel>
            @endauth
        </div>
        <aside class="space-y-4" data-aos="fade-left">
            <x-ui.glass-panel class="text-center">
                <p class="mb-3 text-sm font-semibold">Verification QR</p>
                @if ($qr)<img src="data:image/png;base64,{{ $qr }}" class="mx-auto rounded-xl">@else<p class="font-mono text-xs">{{ $item->verification_code }}</p>@endif
            </x-ui.glass-panel>
            @auth
                <x-ui.glass-panel class="space-y-3">
                    <form method="POST" action="{{ route('found-items.bookmark', $item) }}">@csrf<x-ui.btn type="submit" variant="secondary" class="w-full justify-center">⭐ Bookmark</x-ui.btn></form>
                    <x-ui.btn variant="primary" :href="route('messages.create', ['receiver_id' => $item->user_id, 'found_item_id' => $item->id])" class="w-full justify-center">✉️ Contact reporter</x-ui.btn>
                    @can('update', $item)
                        <x-ui.btn :href="route('found-items.edit', $item)" variant="secondary" class="w-full justify-center">Edit</x-ui.btn>
                        <form method="POST" action="{{ route('found-items.returned', $item) }}">@csrf<x-ui.btn type="submit" variant="success" class="w-full justify-center">Mark returned</x-ui.btn></form>
                    @endcan
                    <x-ui.btn :href="route('found-items.pdf', $item)" variant="ghost" class="w-full justify-center">Export PDF</x-ui.btn>
                </x-ui.glass-panel>
            @endauth
        </aside>
    </div>
</div>
@endsection
