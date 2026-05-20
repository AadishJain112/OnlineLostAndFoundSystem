<div x-data="uploadZone" class="relative" data-aos="fade-up">
    <label
        class="flex min-h-[160px] cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed transition-all duration-300"
        :class="dragging ? 'border-brand-500 bg-brand-500/10 scale-[1.02]' : 'border-slate-300/80 bg-white/40 hover:border-brand-400 hover:bg-brand-500/5 dark:border-slate-600 dark:bg-slate-800/30'"
        @dragover.prevent="dragging = true"
        @dragleave.prevent="dragging = false"
        @drop.prevent="onDrop($event)"
    >
        <input type="file" name="{{ $name ?? 'images[]' }}" accept="image/*" multiple class="sr-only" data-image-preview-input @change="onSelect($event)">
        <div class="text-center p-6">
            <div class="mx-auto mb-3 flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-brand-500/20 to-violet-500/20 text-2xl">📷</div>
            <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">Drag & drop images here</p>
            <p class="mt-1 text-xs text-slate-500">or click to browse · max 5 images · 4MB each</p>
        </div>
    </label>
    <div class="mt-4 flex flex-wrap gap-3" data-image-preview-container></div>
</div>
