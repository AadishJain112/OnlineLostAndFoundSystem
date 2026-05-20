<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\FoundItem;
use App\Models\LostItem;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    public function storeLost(StoreCommentRequest $request, LostItem $lostItem): RedirectResponse
    {
        $lostItem->comments()->create([
            'user_id' => $request->user()->id,
            'body' => $request->validated('body'),
        ]);

        return back()->with('success', 'Comment posted.');
    }

    public function storeFound(StoreCommentRequest $request, FoundItem $foundItem): RedirectResponse
    {
        $foundItem->comments()->create([
            'user_id' => $request->user()->id,
            'body' => $request->validated('body'),
        ]);

        return back()->with('success', 'Comment posted.');
    }
}
