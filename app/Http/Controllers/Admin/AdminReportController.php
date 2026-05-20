<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FoundItem;
use App\Models\LostItem;
use App\Services\ImageUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminReportController extends Controller
{
    public function __construct(protected ImageUploadService $imageUploadService) {}

    public function index(Request $request): View
    {
        $type = $request->get('type', 'lost');

        return view('admin.reports.index', [
            'type' => $type,
            'lostItems' => LostItem::with(['user', 'category'])->latest()->paginate(15, ['*'], 'lost_page'),
            'foundItems' => FoundItem::with(['user', 'category'])->latest()->paginate(15, ['*'], 'found_page'),
        ]);
    }

    public function destroyLost(LostItem $lostItem): RedirectResponse
    {
        $this->imageUploadService->deleteAll($lostItem);
        $lostItem->delete();

        return back()->with('success', 'Lost report removed.');
    }

    public function destroyFound(FoundItem $foundItem): RedirectResponse
    {
        $this->imageUploadService->deleteAll($foundItem);
        $foundItem->delete();

        return back()->with('success', 'Found report removed.');
    }
}
