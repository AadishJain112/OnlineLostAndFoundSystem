<x-app-layout>
    <x-slot name="header"><h2 class="font-display text-xl font-bold gradient-text">User Management</h2></x-slot>
    <x-layouts.dashboard>
        <x-ui.page-header title="Users" subtitle="Manage accounts, roles, and access." gradient />
        <x-ui.glass-panel class="overflow-hidden p-0">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="border-b border-slate-200/50 bg-white/40 dark:border-slate-700 dark:bg-slate-800/40">
                        <tr>
                            <th class="px-6 py-4 text-left font-semibold">User</th>
                            <th class="px-6 py-4 text-left font-semibold">Email</th>
                            <th class="px-6 py-4 text-left font-semibold">Reports</th>
                            <th class="px-6 py-4 text-left font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="border-b border-slate-100/80 transition-colors hover:bg-brand-500/5 dark:border-slate-800" data-aos="fade-up">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gradient-to-br from-brand-500 to-violet-500 text-xs font-bold text-white">{{ strtoupper(substr($user->name,0,1)) }}</div>
                                        <span class="font-medium">{{ $user->name }}</span>
                                        @if($user->is_admin)<span class="rounded-full bg-brand-500/10 px-2 py-0.5 text-xs text-brand-600">Admin</span>@endif
                                        @if($user->is_blocked)<span class="rounded-full bg-red-500/10 px-2 py-0.5 text-xs text-red-600">Blocked</span>@endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-slate-500">{{ $user->email }}</td>
                                <td class="px-6 py-4">{{ $user->lost_items_count + $user->found_items_count }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-2">
                                        <form method="POST" action="{{ route('admin.users.block', $user) }}">@csrf @method('PATCH')<x-ui.btn type="submit" variant="ghost" class="!px-2 !py-1 text-xs">{{ $user->is_blocked ? 'Unblock' : 'Block' }}</x-ui.btn></form>
                                        <form method="POST" action="{{ route('admin.users.admin', $user) }}">@csrf @method('PATCH')<x-ui.btn type="submit" variant="ghost" class="!px-2 !py-1 text-xs">Admin</x-ui.btn></form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-ui.glass-panel>
        <div class="mt-6">{{ $users->links() }}</div>
    </x-layouts.dashboard>
</x-app-layout>
