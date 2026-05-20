<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl">Report Management</h2></x-slot>
    <x-layouts.dashboard>
        <h3 class="font-semibold mb-2">Lost reports</h3>
        @foreach ($lostItems as $item)
            <div class="mb-2 flex items-center justify-between rounded-lg border bg-white p-3 text-sm dark:border-slate-700 dark:bg-slate-800">
                <span>{{ $item->title }} — {{ $item->user->name }}</span>
                <form method="POST" action="{{ route('admin.reports.lost.destroy', $item) }}" onsubmit="return confirm('Remove spam report?')">@csrf @method('DELETE')<button class="text-red-600 text-xs">Delete</button></form>
            </div>
        @endforeach
        {{ $lostItems->links() }}
        <h3 class="font-semibold mb-2 mt-8">Found reports</h3>
        @foreach ($foundItems as $item)
            <div class="mb-2 flex items-center justify-between rounded-lg border bg-white p-3 text-sm dark:border-slate-700 dark:bg-slate-800">
                <span>{{ $item->title }} — {{ $item->user->name }}</span>
                <form method="POST" action="{{ route('admin.reports.found.destroy', $item) }}" onsubmit="return confirm('Remove?')">@csrf @method('DELETE')<button class="text-red-600 text-xs">Delete</button></form>
            </div>
        @endforeach
        {{ $foundItems->links() }}
    </x-layouts.dashboard>
</x-app-layout>
