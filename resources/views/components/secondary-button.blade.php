<button {{ $attributes->merge(['type' => 'button', 'class' => 'glass btn-glow inline-flex items-center justify-center rounded-xl px-5 py-2.5 text-sm font-semibold text-slate-700 transition-all hover:-translate-y-0.5 dark:text-slate-200']) }} data-ripple>
    {{ $slot }}
</button>
