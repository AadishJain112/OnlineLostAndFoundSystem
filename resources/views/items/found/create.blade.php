<x-app-layout>
    <x-slot name="header"><h2 class="font-display text-xl font-bold gradient-text">Report found item</h2></x-slot>
    <x-layouts.dashboard>
        <x-ui.glass-panel>
            <form method="POST" action="{{ route('found-items.store') }}" enctype="multipart/form-data">
                @csrf
                @include('items.partials.form-fields', ['categories' => $categories, 'dateField' => 'date_found', 'dateLabel' => 'Date found'])
                <div class="mt-8"><x-ui.btn type="submit" variant="success">Create report</x-ui.btn></div>
            </form>
        </x-ui.glass-panel>
    </x-layouts.dashboard>
</x-app-layout>
