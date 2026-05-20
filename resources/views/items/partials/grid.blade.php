<div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3" data-results-grid>
    @forelse ($items as $item)
        <x-item-card :item="$item" :type="$type" />
    @empty
        <div class="col-span-full">
            <x-empty-state title="No reports found" message="Try adjusting your search filters." />
        </div>
    @endforelse
</div>
@if ($items->hasPages())
    <div class="mt-10 flex justify-center" data-aos="fade-up">
        <div class="glass rounded-2xl px-4 py-2">
            {{ $items->links() }}
        </div>
    </div>
@endif
