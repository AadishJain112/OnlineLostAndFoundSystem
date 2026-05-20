@extends('layouts.public')
@section('title', 'Home - '.config('app.name'))
@section('content')

{{-- Hero --}}
<section class="relative overflow-hidden px-4 pb-20 pt-8 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl">
        <div class="grid items-center gap-12 lg:grid-cols-2">
            <div data-aos="fade-right">
                <span class="inline-flex items-center gap-2 rounded-full border border-brand-500/30 bg-brand-500/10 px-4 py-1.5 text-xs font-semibold text-brand-700 dark:text-brand-300">
                    <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse-soft"></span>
                    Smart matching · Secure messaging
                </span>
                <h1 class="mt-6 font-display text-4xl font-extrabold leading-tight tracking-tight sm:text-5xl lg:text-6xl text-balance">
                    <span class="gradient-text">Lost something?</span><br>
                    <span class="text-slate-900 dark:text-white">We'll help you find it.</span>
                </h1>
                <p class="mt-6 max-w-xl text-lg text-slate-600 dark:text-slate-400">
                    Report lost & found items, get instant match alerts, and reconnect safely through our premium community platform.
                </p>
                <div class="mt-10 flex flex-wrap gap-4">
                    @auth
                        <x-ui.btn variant="primary" :href="route('lost-items.create')">Report Lost Item</x-ui.btn>
                        <x-ui.btn variant="success" :href="route('found-items.create')">Report Found Item</x-ui.btn>
                    @else
                        <x-ui.btn variant="primary" :href="route('register')">Get Started Free</x-ui.btn>
                        <x-ui.btn variant="secondary" :href="route('lost-items.index')">Browse Reports</x-ui.btn>
                    @endauth
                </div>
            </div>

            {{-- Floating cards illustration --}}
            <div class="relative hidden h-[420px] lg:block" data-aos="fade-left">
                <div class="absolute left-0 top-8 w-56 animate-float glass rounded-2xl p-4 shadow-glass-lg" data-tilt>
                    <div class="mb-2 text-2xl">📱</div>
                    <p class="text-sm font-bold">Electronics</p>
                    <p class="text-xs text-slate-500">Lost · Downtown</p>
                </div>
                <div class="absolute right-4 top-0 w-52 animate-float-delayed glass rounded-2xl p-4 shadow-glass-lg" data-tilt>
                    <div class="mb-2 text-2xl">👛</div>
                    <p class="text-sm font-bold">Wallet found</p>
                    <p class="text-xs text-emerald-600 font-medium">Match 87%</p>
                </div>
                <div class="absolute bottom-8 left-1/4 w-60 glass-strong rounded-2xl p-5 shadow-glass-lg" data-tilt>
                    <div class="flex items-center gap-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-brand-500 to-violet-600 text-white text-xl">✓</div>
                        <div>
                            <p class="font-bold text-sm">Item matched!</p>
                            <p class="text-xs text-slate-500">Notification sent</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="mt-16 grid gap-4 sm:grid-cols-3" data-aos="fade-up">
            <x-ui.stat-card label="Lost reports" :value="$stats['lost']" icon="🔴" color="amber" />
            <x-ui.stat-card label="Found reports" :value="$stats['found']" icon="🟢" color="emerald" />
            <x-ui.stat-card label="Categories" :value="$stats['categories']" icon="📁" color="violet" />
        </div>
    </div>
</section>

{{-- Categories --}}
<section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
    <x-ui.page-header title="Browse by category" subtitle="Find reports organized by item type." gradient />
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($categories as $category)
            <a href="{{ route('lost-items.index', ['category_id' => $category->id]) }}"
               class="glass card-tilt group rounded-2xl p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-lift"
               data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}" data-tilt>
                <span class="text-3xl transition-transform duration-300 group-hover:scale-125 inline-block">{{ $category->icon }}</span>
                <h3 class="mt-3 font-display font-bold text-slate-900 dark:text-white">{{ $category->name }}</h3>
                <p class="mt-1 text-xs text-slate-500">Explore reports →</p>
            </a>
        @endforeach
    </div>
</section>

{{-- Recent items --}}
<section class="mx-auto max-w-7xl grid gap-12 px-4 pb-20 sm:px-6 lg:grid-cols-2 lg:px-8">
    <div data-aos="fade-up">
        <div class="mb-6 flex items-center justify-between">
            <h2 class="font-display text-2xl font-bold">Recent lost</h2>
            <x-ui.btn variant="ghost" :href="route('lost-items.index')">View all →</x-ui.btn>
        </div>
        <div class="grid gap-6 sm:grid-cols-2">
            @forelse ($recentLost as $item)
                <x-item-card :item="$item" type="lost" />
            @empty
                <x-empty-state class="col-span-full" />
            @endforelse
        </div>
    </div>
    <div data-aos="fade-up" data-aos-delay="100">
        <div class="mb-6 flex items-center justify-between">
            <h2 class="font-display text-2xl font-bold">Recent found</h2>
            <x-ui.btn variant="ghost" :href="route('found-items.index')">View all →</x-ui.btn>
        </div>
        <div class="grid gap-6 sm:grid-cols-2">
            @forelse ($recentFound as $item)
                <x-item-card :item="$item" type="found" />
            @empty
                <x-empty-state class="col-span-full" />
            @endforelse
        </div>
    </div>
</section>
@endsection
