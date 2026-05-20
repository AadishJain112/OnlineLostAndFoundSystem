<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    public function index(): View
    {
        return view('admin.users.index', [
            'users' => User::withCount(['lostItems', 'foundItems'])->latest()->paginate(20),
        ]);
    }

    public function toggleBlock(User $user): RedirectResponse
    {
        $user->update([
            'is_blocked' => ! $user->is_blocked,
            'blocked_at' => ! $user->is_blocked ? now() : null,
        ]);

        return back()->with('success', 'User block status updated.');
    }

    public function toggleAdmin(User $user): RedirectResponse
    {
        $user->update(['is_admin' => ! $user->is_admin]);

        return back()->with('success', 'Admin role updated.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return back()->with('success', 'User deleted.');
    }
}
