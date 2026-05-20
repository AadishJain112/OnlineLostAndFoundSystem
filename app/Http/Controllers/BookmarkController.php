<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\FoundItem;
use App\Models\LostItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BookmarkController extends Controller
{
    public function index(): View
    {
        $bookmarks = auth()->user()->bookmarks()->with('bookmarkable')->latest()->paginate(12);

        return view('user.bookmarks', compact('bookmarks'));
    }

    public function toggleLost(LostItem $lostItem): RedirectResponse
    {
        $this->toggle($lostItem);

        return back()->with('success', 'Bookmark updated.');
    }

    public function toggleFound(FoundItem $foundItem): RedirectResponse
    {
        $this->toggle($foundItem);

        return back()->with('success', 'Bookmark updated.');
    }

    private function toggle(LostItem|FoundItem $item): void
    {
        $bookmark = Bookmark::where([
            'user_id' => auth()->id(),
            'bookmarkable_type' => $item::class,
            'bookmarkable_id' => $item->id,
        ])->first();

        if ($bookmark) {
            $bookmark->delete();
        } else {
            Bookmark::create([
                'user_id' => auth()->id(),
                'bookmarkable_type' => $item::class,
                'bookmarkable_id' => $item->id,
            ]);
        }
    }
}
