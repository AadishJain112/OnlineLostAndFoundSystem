<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-glow inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-brand-600 to-brand-500 px-5 py-2.5 text-sm font-semibold text-white shadow-glow-sm transition-all duration-300 hover:from-brand-500 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900']) }} data-ripple>
    {{ $slot }}
</button>
