@props(['item' => null, 'dateField' => 'date_lost', 'dateLabel' => 'Date lost'])

<div class="space-y-6">
    <div data-aos="fade-up">
        <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Category</label>
        <select name="category_id" class="input-float !py-3 w-full" required>
            <option value="">Select category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $item?->category_id) == $category->id)>{{ $category->icon }} {{ $category->name }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
    </div>

    <x-ui.input-floating label="Title" name="title" :value="old('title', $item?->title)" required data-aos="fade-up" />
    <x-input-error :messages="$errors->get('title')" class="-mt-4" />

    <div data-aos="fade-up">
        <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Description</label>
        <textarea name="description" rows="4" class="input-float min-h-[120px] w-full resize-y" required>{{ old('description', $item?->description) }}</textarea>
        <x-input-error :messages="$errors->get('description')" class="mt-2" />
    </div>

    <div class="grid gap-6 md:grid-cols-2" data-aos="fade-up">
        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $dateLabel }}</label>
            <input type="date" name="{{ $dateField }}" value="{{ old($dateField, optional($item?->{$dateField})->format('Y-m-d')) }}" class="input-float w-full !py-3" required>
            <x-input-error :messages="$errors->get($dateField)" class="mt-2" />
        </div>
        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Contact preference</label>
            <select name="contact_preference" class="input-float w-full !py-3">
                @foreach (['platform' => 'Platform messaging', 'email' => 'Email', 'phone' => 'Phone'] as $value => $label)
                    <option value="{{ $value }}" @selected(old('contact_preference', $item?->contact_preference?->value ?? 'platform') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div data-aos="fade-up">
        <x-ui.input-floating label="Location" name="location" :value="old('location', $item?->location)" required data-location-input />
        <x-input-error :messages="$errors->get('location')" class="mt-2" />
        <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $item?->latitude) }}">
        <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $item?->longitude) }}">
        <div id="map-picker" data-map-picker class="mt-3 flex h-48 cursor-crosshair items-center justify-center rounded-2xl border-2 border-dashed border-brand-500/30 bg-gradient-to-br from-brand-500/5 to-violet-500/5 text-sm text-slate-500 transition-all hover:border-brand-500/50">
            🗺️ Click to set map coordinates
        </div>
    </div>

    <div data-aos="fade-up">
        <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-300">Images (max 5)</label>
        <x-ui.upload-zone />
        <x-input-error :messages="$errors->get('images.*')" class="mt-2" />
    </div>
</div>
