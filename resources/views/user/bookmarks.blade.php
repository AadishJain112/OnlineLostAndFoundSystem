<x-app-layout>
    <x-slot name="header"><h2 class="font-display text-xl font-bold gradient-text">Bookmarks</h2></x-slot>
    <x-layouts.dashboard>
        <x-ui.page-header title="Saved reports" subtitle="Items you've bookmarked for later." gradient />
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($bookmarks as $bookmark)
                @if ($bookmark->bookmarkable)
                    <x-item-card :item="$bookmark->bookmarkable" :type="$bookmark->bookmarkable instanceof \App\Models\LostItem ? 'lost' : 'found'" />
                @endif
            @empty
                <x-empty-state class="col-span-full" />
            @endforelse
        </div>
        {{ $bookmarks->links() }}
    </x-layouts.dashboard>
</x-app-layout>
