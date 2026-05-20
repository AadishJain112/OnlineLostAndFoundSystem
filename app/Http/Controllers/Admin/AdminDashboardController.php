<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\FoundItem;
use App\Models\ItemMatch;
use App\Models\LostItem;
use App\Models\Message;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'stats' => [
                'users' => User::count(),
                'lost' => LostItem::count(),
                'found' => FoundItem::count(),
                'matches' => ItemMatch::count(),
                'messages' => Message::count(),
                'comments' => Comment::count(),
                'categories' => Category::count(),
            ],
            'recentUsers' => User::latest()->take(5)->get(),
            'recentLost' => LostItem::with('user')->latest()->take(5)->get(),
            'recentFound' => FoundItem::with('user')->latest()->take(5)->get(),
        ]);
    }
}
