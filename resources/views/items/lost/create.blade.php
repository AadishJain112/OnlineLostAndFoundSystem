<x-app-layout>
    <x-slot name="header"><h2 class="font-display text-xl font-bold gradient-text">Report lost item</h2></x-slot>
    <x-layouts.dashboard>
        <x-ui.glass-panel>
            <form method="POST" action="{{ route('lost-items.store') }}" enctype="multipart/form-data">
                @csrf
                @include('items.partials.form-fields', ['categories' => $categories, 'dateField' => 'date_lost', 'dateLabel' => 'Date lost'])
                <div class="mt-8 flex gap-3">
                    <x-ui.btn type="submit" variant="primary">Create report</x-ui.btn>
                    <x-ui.btn variant="secondary" :href="route('my-reports.index')">Cancel</x-ui.btn>
                </div>
            </form>
        </x-ui.glass-panel>
    </x-layouts.dashboard>
</x-app-layout>
