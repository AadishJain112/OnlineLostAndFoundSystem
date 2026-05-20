<x-app-layout>
    <x-slot name="header"><h2 class="font-display text-xl font-bold gradient-text">Edit lost item</h2></x-slot>
    <x-layouts.dashboard>
        <x-ui.glass-panel>
            <form method="POST" action="{{ route('lost-items.update', $item) }}" enctype="multipart/form-data">
                @csrf @method('PUT')
                @include('items.partials.form-fields', ['item' => $item, 'categories' => $categories, 'dateField' => 'date_lost', 'dateLabel' => 'Date lost'])
                <div class="mt-8"><x-ui.btn type="submit" variant="primary">Save changes</x-ui.btn></div>
            </form>
        </x-ui.glass-panel>
        <form method="POST" action="{{ route('lost-items.destroy', $item) }}" class="mt-4" onsubmit="return confirm('Delete this report?')">
            @csrf @method('DELETE')
            <x-ui.btn type="submit" variant="danger">Delete report</x-ui.btn>
        </form>
    </x-layouts.dashboard>
</x-app-layout>
