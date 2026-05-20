@extends('layouts.public')
@section('title', 'Browse Lost Items')
@section('content')
<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
    <x-ui.page-header title="Browse lost items" subtitle="Help reunite people with what they've lost." gradient>
        <x-slot name="actions">
            @auth
                <x-ui.btn variant="primary" :href="route('lost-items.create')">+ Report lost item</x-ui.btn>
            @endauth
        </x-slot>
    </x-ui.page-header>

    @include('items.partials.filters', [
        'searchRoute' => route('lost-items.search'),
        'indexRoute' => route('lost-items.index'),
    ])

    <div data-live-search-results class="transition-opacity duration-300">
        @include('items.partials.grid', ['items' => $items, 'type' => 'lost'])
    </div>
</div>
@endsection
