@props(['item', 'type' => 'lost'])

@php
    $route = $type === 'lost' ? 'lost-items.show' : 'found-items.show';
    $dateLabel = $type === 'lost' ? 'Lost' : 'Found';
    $dateValue = $type === 'lost' ? $item->date_lost : $item->date_found;
    $accent = $type === 'lost' ? 'from-amber-500/50 via-brand-500/30 to-violet-500/50' : 'from-emerald-500/50 via-teal-500/30 to-brand-500/50';
@endphp

<article
    data-tilt
    data-tilt-max="14"
    data-aos="fade-up"
    class="card-tilt group relative flex flex-col overflow-hidden rounded-2xl bg-gradient-to-br {{ $accent }} p-[1px] transition-all duration-500 hover:shadow-lift"
>
    <div class="flex h-full flex-col overflow-hidden rounded-2xl glass">
        <div class="relative aspect-[4/3] overflow-hidden bg-slate-100 dark:bg-slate-800">
            @if ($item->images->first())
                <img
                    src="{{ $item->images->first()->url() }}"
                    alt="{{ $item->title }}"
                    class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110"
                    loading="lazy"
                >
            @else
                <div class="flex h-full items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200 text-6xl dark:from-slate-800 dark:to-slate-900">
                    {{ $item->category->icon ?? '📦' }}
                </div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
            <div class="absolute left-3 top-3">
                <x-status-badge :status="$item->status" />
            </div>
        </div>

        <div class="flex flex-1 flex-col p-5">
            <div class="mb-2 flex items-start justify-between gap-2">
                <h3 class="font-display text-lg font-bold leading-tight text-slate-900 line-clamp-2 dark:text-white group-hover:text-brand-600 dark:group-hover:text-brand-400 transition-colors">
                    {{ $item->title }}
                </h3>
            </div>
            <p class="mb-4 flex-1 text-sm leading-relaxed text-slate-600 line-clamp-2 dark:text-slate-400">
                {{ Str::limit($item->description, 90) }}
            </p>
            <div class="space-y-1.5 text-xs text-slate-500 dark:text-slate-400">
                <p class="flex items-center gap-1.5">
                    <span>{{ $item->category->icon ?? '📁' }}</span>
                    <span class="font-medium">{{ $item->category->name }}</span>
                    <span class="text-slate-300">·</span>
                    {{ $dateLabel }} {{ $dateValue->format('M d, Y') }}
                </p>
                <p class="flex items-center gap-1.5 line-clamp-1">
                    <span>📍</span> {{ $item->location }}
                </p>
            </div>
            <a
                href="{{ route($route, $item) }}"
                class="btn-glow mt-5 inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-brand-600 to-brand-500 px-4 py-2.5 text-sm font-semibold text-white shadow-glow-sm transition-all hover:from-brand-500"
                data-ripple
            >
                View details
                <svg class="ml-1 h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>
</article>
