<aside class="w-full shrink-0 lg:w-64">
    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-700 dark:bg-slate-800">
        <p class="mb-3 text-xs font-semibold uppercase tracking-wide text-slate-500">User Menu</p>
        <nav class="space-y-1 text-sm">
            <a href="{{ route('dashboard') }}" class="block rounded-lg px-3 py-2 hover:bg-indigo-50 dark:hover:bg-slate-700 {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700 dark:bg-slate-700' : '' }}">Dashboard</a>
            <a href="{{ route('my-reports.index') }}" class="block rounded-lg px-3 py-2 hover:bg-indigo-50 dark:hover:bg-slate-700 {{ request()->routeIs('my-reports.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-slate-700' : '' }}">My Reports</a>
            <a href="{{ route('lost-items.create') }}" class="block rounded-lg px-3 py-2 hover:bg-indigo-50 dark:hover:bg-slate-700">Report Lost Item</a>
            <a href="{{ route('found-items.create') }}" class="block rounded-lg px-3 py-2 hover:bg-indigo-50 dark:hover:bg-slate-700">Report Found Item</a>
            <a href="{{ route('notifications.index') }}" class="block rounded-lg px-3 py-2 hover:bg-indigo-50 dark:hover:bg-slate-700 {{ request()->routeIs('notifications.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-slate-700' : '' }}">Notifications</a>
            <a href="{{ route('messages.index') }}" class="block rounded-lg px-3 py-2 hover:bg-indigo-50 dark:hover:bg-slate-700 {{ request()->routeIs('messages.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-slate-700' : '' }}">Messages</a>
            <a href="{{ route('bookmarks.index') }}" class="block rounded-lg px-3 py-2 hover:bg-indigo-50 dark:hover:bg-slate-700 {{ request()->routeIs('bookmarks.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-slate-700' : '' }}">Bookmarks</a>
            <a href="{{ route('profile.edit') }}" class="block rounded-lg px-3 py-2 hover:bg-indigo-50 dark:hover:bg-slate-700 {{ request()->routeIs('profile.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-slate-700' : '' }}">Profile Settings</a>
            @if (auth()->user()->isAdmin())
                <hr class="my-2 border-slate-200 dark:border-slate-600">
                <p class="px-3 text-xs font-semibold uppercase text-slate-500">Admin</p>
                <a href="{{ route('admin.dashboard') }}" class="block rounded-lg px-3 py-2 hover:bg-indigo-50 dark:hover:bg-slate-700">Admin Dashboard</a>
                <a href="{{ route('admin.users.index') }}" class="block rounded-lg px-3 py-2 hover:bg-indigo-50 dark:hover:bg-slate-700">Users</a>
                <a href="{{ route('admin.reports.index') }}" class="block rounded-lg px-3 py-2 hover:bg-indigo-50 dark:hover:bg-slate-700">Reports</a>
                <a href="{{ route('admin.categories.index') }}" class="block rounded-lg px-3 py-2 hover:bg-indigo-50 dark:hover:bg-slate-700">Categories</a>
            @endif
        </nav>
    </div>
</aside>
