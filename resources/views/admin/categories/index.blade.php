<x-app-layout>
    <x-slot name="header"><h2 class="font-display text-xl font-bold gradient-text">Categories</h2></x-slot>
    <x-layouts.dashboard>
        <x-ui.page-header title="Category management" gradient />
        <x-ui.glass-panel class="mb-6">
            <form method="POST" action="{{ route('admin.categories.store') }}" class="grid gap-4 md:grid-cols-4 items-end">
                @csrf
                <x-ui.input-floating label="Name" name="name" required />
                <x-ui.input-floating label="Icon (emoji)" name="icon" />
                <x-ui.input-floating label="Description" name="description" class="md:col-span-2" />
                <x-ui.btn type="submit" variant="primary">Add category</x-ui.btn>
            </form>
        </x-ui.glass-panel>
        @foreach ($categories as $category)
            <x-ui.glass-panel class="mb-4" data-aos="fade-up">
                <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="grid gap-4 md:grid-cols-5 items-end">
                    @csrf @method('PATCH')
                    <x-ui.input-floating label="Name" name="name" :value="$category->name" />
                    <x-ui.input-floating label="Icon" name="icon" :value="$category->icon" />
                    <x-ui.input-floating label="Description" name="description" :value="$category->description" class="md:col-span-2" />
                    <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_active" value="1" @checked($category->is_active) class="rounded text-brand-600"> Active</label>
                    <x-ui.btn type="submit" variant="primary">Save</x-ui.btn>
                </form>
            </x-ui.glass-panel>
        @endforeach
        {{ $categories->links() }}
    </x-layouts.dashboard>
</x-app-layout>
