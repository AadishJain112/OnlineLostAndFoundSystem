<?php

namespace App\Http\Controllers;

use App\Models\FoundItem;
use App\Models\ItemMatch;
use App\Models\LostItem;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        return view('user.dashboard', [
            'lostCount' => $user->lostItems()->count(),
            'foundCount' => $user->foundItems()->count(),
            'matches' => ItemMatch::query()
                ->with(['lostItem', 'foundItem'])
                ->where(function ($query) use ($user) {
                    $query->whereHas('lostItem', fn ($q) => $q->where('user_id', $user->id))
                        ->orWhereHas('foundItem', fn ($q) => $q->where('user_id', $user->id));
                })
                ->latest()
                ->take(5)
                ->get(),
            'recentLost' => $user->lostItems()->with('category')->latest()->take(5)->get(),
            'recentFound' => $user->foundItems()->with('category')->latest()->take(5)->get(),
            'unreadNotifications' => $user->unreadNotifications()->count(),
            'unreadMessages' => $user->receivedMessages()->whereNull('read_at')->count(),
        ]);
    }
}
