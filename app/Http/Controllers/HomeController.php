<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\FoundItem;
use App\Models\LostItem;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('public.home', [
            'stats' => [
                'lost' => LostItem::count(),
                'found' => FoundItem::count(),
                'categories' => Category::where('is_active', true)->count(),
            ],
            'recentLost' => LostItem::with(['category', 'images'])->latest()->take(4)->get(),
            'recentFound' => FoundItem::with(['category', 'images'])->latest()->take(4)->get(),
            'categories' => Category::where('is_active', true)->orderBy('name')->get(),
        ]);
    }
}
