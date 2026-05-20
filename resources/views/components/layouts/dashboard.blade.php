<div class="flex flex-col gap-8 lg:flex-row">
    @include('layouts.partials.sidebar-app')
    <div class="min-w-0 flex-1">
        {{ $slot }}
    </div>
</div>
