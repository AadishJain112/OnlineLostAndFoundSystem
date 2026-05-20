@props(['title', 'subtitle' => null, 'gradient' => false])

<div {{ $attributes->merge(['class' => 'mb-8']) }} data-aos="fade-up">
    @if (isset($badge))
        <div class="mb-3">{{ $badge }}</div>
    @endif
    <h1 class="font-display text-3xl font-bold tracking-tight text-balance sm:text-4xl">
        @if ($gradient)
            <span class="gradient-text">{{ $title }}</span>
        @else
            <span class="text-slate-900 dark:text-white">{{ $title }}</span>
        @endif
    </h1>
    @if ($subtitle)
        <p class="mt-2 max-w-2xl text-base text-slate-600 dark:text-slate-400">{{ $subtitle }}</p>
    @endif
    @if (isset($actions))
        <div class="mt-5 flex flex-wrap gap-3">{{ $actions }}</div>
    @endif
</div>
