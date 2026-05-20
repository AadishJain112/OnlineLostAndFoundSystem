@props(['type' => 'success'])

@php
    $classes = match($type) {
        'success' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
        'error' => 'bg-red-50 text-red-800 border-red-200',
        'info' => 'bg-sky-50 text-sky-800 border-sky-200',
        default => 'bg-slate-50 text-slate-800 border-slate-200',
    };
@endphp

@if (session($type) || ($type === 'success' && session('status')))
    <div {{ $attributes->merge(['class' => "mb-4 rounded-lg border px-4 py-3 text-sm {$classes}"]) }} role="alert">
        {{ $slot->isEmpty() ? (session($type) ?? session('status')) : $slot }}
    </div>
@endif
