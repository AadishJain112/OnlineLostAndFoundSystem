@props(['variant' => 'primary', 'href' => null, 'type' => 'button'])

@php
    $base = 'btn-glow inline-flex items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-slate-900';
    $variants = [
        'primary' => 'bg-gradient-to-r from-brand-600 to-brand-500 text-white shadow-glow-sm hover:from-brand-500 hover:to-brand-400 focus:ring-brand-500',
        'secondary' => 'glass text-slate-700 hover:bg-white/90 dark:text-slate-200 dark:hover:bg-slate-800/80 focus:ring-slate-400',
        'ghost' => 'text-slate-600 hover:bg-slate-100/80 dark:text-slate-300 dark:hover:bg-slate-800/50',
        'danger' => 'bg-gradient-to-r from-red-600 to-rose-600 text-white hover:from-red-500 focus:ring-red-500',
        'success' => 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white hover:from-emerald-500 focus:ring-emerald-500',
    ];
    $class = $base . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $class]) }} data-ripple>{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $class]) }} data-ripple>{{ $slot }}</button>
@endif
