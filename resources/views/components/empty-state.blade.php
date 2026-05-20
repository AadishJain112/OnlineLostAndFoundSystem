@props(['title' => 'Nothing here yet', 'message' => 'Check back later for new reports.'])

<div {{ $attributes->merge(['class' => 'glass flex flex-col items-center rounded-2xl border border-dashed border-slate-300/80 px-8 py-16 text-center dark:border-slate-600']) }} data-aos="zoom-in">
    <div class="mb-4 flex h-20 w-20 items-center justify-center rounded-2xl bg-gradient-to-br from-brand-500/20 to-violet-500/20 text-4xl animate-float">🔍</div>
    <h3 class="font-display text-xl font-bold text-slate-900 dark:text-white">{{ $title }}</h3>
    <p class="mt-2 max-w-sm text-sm text-slate-600 dark:text-slate-400">{{ $message }}</p>
    @if (isset($action))
        <div class="mt-6">{{ $action }}</div>
    @endif
</div>
