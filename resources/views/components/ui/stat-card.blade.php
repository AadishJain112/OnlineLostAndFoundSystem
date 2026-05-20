@props(['label', 'value', 'icon' => '📊', 'color' => 'brand', 'animate' => true])

@php
    $gradients = [
        'brand' => 'from-brand-500/20 to-brand-600/5 border-brand-500/20',
        'violet' => 'from-violet-500/20 to-violet-600/5 border-violet-500/20',
        'emerald' => 'from-emerald-500/20 to-emerald-600/5 border-emerald-500/20',
        'amber' => 'from-amber-500/20 to-amber-600/5 border-amber-500/20',
        'rose' => 'from-rose-500/20 to-rose-600/5 border-rose-500/20',
    ];
    $g = $gradients[$color] ?? $gradients['brand'];
@endphp

<div {{ $attributes->merge(['class' => "glass card-tilt group relative overflow-hidden rounded-2xl border bg-gradient-to-br p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-lift {$g}"]) }} data-aos="fade-up" data-tilt data-tilt-max="8">
    <div class="absolute -right-4 -top-4 text-5xl opacity-20 transition-transform duration-500 group-hover:scale-110">{{ $icon }}</div>
    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ $label }}</p>
    <p class="mt-2 font-display text-3xl font-bold text-slate-900 dark:text-white" @if($animate) data-counter="{{ is_numeric($value) ? $value : 0 }}" @endif>
        @if($animate && is_numeric($value)) 0 @else {{ $value }} @endif
    </p>
    @if(isset($footer))
        <div class="mt-2 text-xs text-slate-500">{{ $footer }}</div>
    @endif
</div>
