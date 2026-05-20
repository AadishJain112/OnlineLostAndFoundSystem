@extends('layouts.public')
@section('title', 'Browse Found Items')
@section('content')
<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
    <x-ui.page-header title="Browse found items" subtitle="Found something? Check if someone is looking for it." gradient>
        <x-slot name="actions">
            @auth
                <x-ui.btn variant="success" :href="route('found-items.create')">+ Report found item</x-ui.btn>
            @endauth
        </x-slot>
    </x-ui.page-header>

    @include('items.partials.filters', [
        'searchRoute' => route('found-items.search'),
        'indexRoute' => route('found-items.index'),
    ])

    <div data-live-search-results class="transition-opacity duration-300">
        @include('items.partials.grid', ['items' => $items, 'type' => 'found'])
    </div>
</div>
@endsection
