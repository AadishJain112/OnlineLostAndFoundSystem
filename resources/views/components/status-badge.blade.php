@props(['status'])

@php
    $value = $status instanceof \App\Enums\ItemStatus ? $status->value : $status;
    $styles = match($value) {
        'lost' => 'from-amber-500/20 to-orange-500/10 text-amber-700 border-amber-500/30 dark:text-amber-300',
        'found' => 'from-emerald-500/20 to-teal-500/10 text-emerald-700 border-emerald-500/30 dark:text-emerald-300',
        'matched' => 'from-sky-500/20 to-brand-500/10 text-sky-700 border-sky-500/30 dark:text-sky-300',
        'returned' => 'from-indigo-500/20 to-violet-500/10 text-indigo-700 border-indigo-500/30 dark:text-indigo-300',
        'closed' => 'from-slate-500/20 to-slate-600/10 text-slate-600 border-slate-500/30 dark:text-slate-400',
        default => 'from-slate-500/20 to-slate-600/10 text-slate-600 border-slate-500/30',
    };
    $label = $status instanceof \App\Enums\ItemStatus ? $status->label() : ucfirst($value);
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center rounded-full border bg-gradient-to-r px-2.5 py-1 text-xs font-semibold backdrop-blur-sm {$styles}"]) }}>
    <span class="mr-1.5 h-1.5 w-1.5 rounded-full bg-current animate-pulse-soft"></span>
    {{ $label }}
</span>
