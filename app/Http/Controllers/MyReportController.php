<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class MyReportController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        return view('user.my-reports', [
            'lostItems' => $user->lostItems()->with(['category', 'images'])->latest()->paginate(10, ['*'], 'lost_page'),
            'foundItems' => $user->foundItems()->with(['category', 'images'])->latest()->paginate(10, ['*'], 'found_page'),
        ]);
    }
}
