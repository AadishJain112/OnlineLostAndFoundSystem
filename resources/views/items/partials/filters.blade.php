<form method="GET" action="{{ $searchRoute }}" data-live-search-form class="glass mb-8 rounded-2xl p-6" data-aos="fade-up">
    <div class="mb-4 flex flex-col gap-4 sm:flex-row sm:items-center">
        <div class="relative flex-1">
            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">🔍</span>
            <input
                type="search"
                name="q"
                value="{{ $filters['q'] ?? '' }}"
                placeholder="Search title, description, location..."
                class="w-full rounded-xl border-0 bg-white/60 py-3.5 pl-12 pr-4 text-sm shadow-inner ring-1 ring-slate-200/80 transition-all focus:ring-2 focus:ring-brand-500/50 dark:bg-slate-800/50 dark:ring-slate-600"
                data-live-search-input
            >
        </div>
        <x-ui.btn type="submit" variant="primary">Search</x-ui.btn>
        <x-ui.btn :href="$indexRoute" variant="secondary">Reset</x-ui.btn>
    </div>

    <div class="flex flex-wrap gap-2 mb-4">
        <span class="text-xs font-semibold uppercase tracking-wider text-slate-400 py-2">Filters:</span>
        @foreach ($categories as $category)
            <label class="cursor-pointer">
                <input type="radio" name="category_id" value="{{ $category->id }}" class="peer sr-only" @checked(($filters['category_id'] ?? '') == $category->id) onchange="this.form.submit()">
                <span class="inline-flex items-center gap-1.5 rounded-full border border-slate-200/80 bg-white/50 px-3 py-1.5 text-xs font-medium transition-all peer-checked:border-brand-500 peer-checked:bg-brand-500/15 peer-checked:text-brand-700 hover:scale-105 dark:border-slate-600 dark:peer-checked:text-brand-300">
                    {{ $category->icon }} {{ $category->name }}
                </span>
            </label>
        @endforeach
    </div>

    <div class="grid gap-4 md:grid-cols-3">
        <div>
            <label class="mb-1 block text-xs font-semibold text-slate-500">Location</label>
            <input type="text" name="location" value="{{ $filters['location'] ?? '' }}" class="input-float !py-3" placeholder="City, area...">
        </div>
        <div>
            <label class="mb-1 block text-xs font-semibold text-slate-500">From</label>
            <input type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}" class="input-float !py-3">
        </div>
        <div>
            <label class="mb-1 block text-xs font-semibold text-slate-500">To</label>
            <input type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}" class="input-float !py-3">
        </div>
    </div>

    <div class="mt-4 hidden items-center gap-2 text-sm text-brand-600" data-loading-indicator>
        <span class="inline-block h-4 w-4 animate-spin rounded-full border-2 border-brand-500 border-t-transparent"></span>
        Searching...
    </div>
</form>
