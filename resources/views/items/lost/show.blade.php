@extends('layouts.public')
@section('title', $item->title)
@section('content')
<div class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8">
    <div class="grid gap-8 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-6">
            <div data-aos="fade-up">
                <div class="mb-4 flex flex-wrap items-center gap-3">
                    <h1 class="font-display text-3xl font-bold text-slate-900 dark:text-white">{{ $item->title }}</h1>
                    <x-status-badge :status="$item->status" />
                </div>
                <p class="text-lg leading-relaxed text-slate-600 dark:text-slate-400">{{ $item->description }}</p>
            </div>

            <x-ui.glass-panel data-aos="fade-up">
                <dl class="grid gap-4 sm:grid-cols-2 text-sm">
                    <div><dt class="font-semibold text-slate-500">Category</dt><dd class="mt-1 font-medium">{{ $item->category->name }}</dd></div>
                    <div><dt class="font-semibold text-slate-500">Date lost</dt><dd class="mt-1 font-medium">{{ $item->date_lost->format('M d, Y') }}</dd></div>
                    <div class="sm:col-span-2"><dt class="font-semibold text-slate-500">Location</dt><dd class="mt-1 font-medium">📍 {{ $item->location }}</dd></div>
                    <div><dt class="font-semibold text-slate-500">Verification</dt><dd class="mt-1 font-mono text-brand-600">{{ $item->verification_code }}</dd></div>
                </dl>
            </x-ui.glass-panel>

            @if ($item->images->count())
                <div class="grid gap-4 sm:grid-cols-2" data-aos="fade-up">
                    @foreach ($item->images as $image)
                        <div class="group overflow-hidden rounded-2xl glass" data-tilt>
                            <img src="{{ $image->url() }}" alt="" class="aspect-video w-full object-cover transition-transform duration-700 group-hover:scale-105">
                        </div>
                    @endforeach
                </div>
            @endif

            @auth
                <x-ui.glass-panel>
                    <h2 class="font-display mb-4 text-lg font-bold">Comments</h2>
                    <div class="mb-4 space-y-3 max-h-64 overflow-y-auto">
                        @foreach ($item->comments as $comment)
                            <div class="rounded-xl bg-white/50 p-4 dark:bg-slate-800/50" data-aos="fade-up">
                                <p class="text-sm font-semibold">{{ $comment->user->name }}</p>
                                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">{{ $comment->body }}</p>
                            </div>
                        @endforeach
                    </div>
                    <form method="POST" action="{{ route('lost-items.comments.store', $item) }}">
                        @csrf
                        <textarea name="body" rows="3" class="input-float w-full min-h-[80px]" placeholder="Add a comment..." required></textarea>
                        <x-ui.btn type="submit" variant="primary" class="mt-3">Post comment</x-ui.btn>
                    </form>
                </x-ui.glass-panel>
            @endauth
        </div>

        <aside class="space-y-4" data-aos="fade-left">
            <x-ui.glass-panel class="text-center">
                <p class="mb-3 text-sm font-semibold">Verification QR</p>
                @if ($qr)
                    <img src="data:image/png;base64,{{ $qr }}" alt="QR" class="mx-auto rounded-xl shadow-glass">
                @else
                    <p class="text-xs text-slate-500 font-mono">{{ $item->verification_code }}</p>
                @endif
            </x-ui.glass-panel>

            @auth
                <x-ui.glass-panel class="space-y-3">
                    <form method="POST" action="{{ route('lost-items.bookmark', $item) }}">@csrf
                        <x-ui.btn type="submit" variant="secondary" class="w-full justify-center">⭐ Bookmark</x-ui.btn>
                    </form>
                    <x-ui.btn variant="primary" :href="route('messages.create', ['receiver_id' => $item->user_id, 'lost_item_id' => $item->id])" class="w-full justify-center">✉️ Contact reporter</x-ui.btn>
                    @can('update', $item)
                        <x-ui.btn variant="secondary" :href="route('lost-items.edit', $item)" class="w-full justify-center">Edit report</x-ui.btn>
                        <form method="POST" action="{{ route('lost-items.recovered', $item) }}">@csrf
                            <x-ui.btn type="submit" variant="success" class="w-full justify-center">Mark recovered</x-ui.btn>
                        </form>
                    @endcan
                    <x-ui.btn variant="ghost" :href="route('lost-items.pdf', $item)" class="w-full justify-center">Export PDF</x-ui.btn>
                </x-ui.glass-panel>
            @endauth
        </aside>
    </div>
</div>
@endsection
