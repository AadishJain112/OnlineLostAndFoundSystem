<x-app-layout>
    <x-slot name="header"><h2 class="font-display text-xl font-bold gradient-text">My Reports</h2></x-slot>
    <x-layouts.dashboard>
        <x-ui.page-header title="Your reports" subtitle="Manage all lost and found items you've submitted." gradient />
        <h3 class="mb-4 font-display text-lg font-bold" data-aos="fade-up">Lost items</h3>
        <div class="mb-10 grid gap-6 sm:grid-cols-2">{{-- cards --}}
            @forelse ($lostItems as $item)
                <x-item-card :item="$item" type="lost" />
            @empty
                <x-empty-state class="col-span-full" title="No lost reports" />
            @endforelse
        </div>
        {{ $lostItems->links() }}
        <h3 class="mb-4 mt-10 font-display text-lg font-bold">Found items</h3>
        <div class="grid gap-6 sm:grid-cols-2">
            @forelse ($foundItems as $item)
                <x-item-card :item="$item" type="found" />
            @empty
                <x-empty-state class="col-span-full" title="No found reports" />
            @endforelse
        </div>
        {{ $foundItems->links() }}
    </x-layouts.dashboard>
</x-app-layout>
