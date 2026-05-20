<?php

namespace App\Http\Controllers;

use App\Enums\MessageStatus;
use App\Http\Requests\StoreMessageRequest;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        return view('user.messages.index', [
            'inbox' => $user->receivedMessages()->with(['sender', 'lostItem', 'foundItem'])->latest()->paginate(15),
            'sent' => $user->sentMessages()->with(['receiver', 'lostItem', 'foundItem'])->latest()->paginate(15, pageName: 'sent_page'),
        ]);
    }

    public function create(Request $request): View
    {
        return view('user.messages.create', [
            'receiver' => User::find($request->integer('receiver_id')),
            'lostItemId' => $request->integer('lost_item_id') ?: null,
            'foundItemId' => $request->integer('found_item_id') ?: null,
        ]);
    }

    public function store(StoreMessageRequest $request): RedirectResponse
    {
        Message::create([
            ...$request->validated(),
            'sender_id' => $request->user()->id,
            'status' => MessageStatus::Pending,
        ]);

        return redirect()->route('messages.index')->with('success', 'Contact request sent securely.');
    }

    public function show(Message $message): View
    {
        abort_unless(
            $message->sender_id === auth()->id() || $message->receiver_id === auth()->id(),
            403
        );

        if ($message->receiver_id === auth()->id() && ! $message->read_at) {
            $message->update(['read_at' => now()]);
        }

        return view('user.messages.show', compact('message'));
    }

    public function updateStatus(Message $message, Request $request): RedirectResponse
    {
        abort_unless($message->receiver_id === auth()->id(), 403);

        $request->validate(['status' => ['required', 'in:accepted,rejected']]);
        $message->update(['status' => $request->status]);

        return back()->with('success', 'Message status updated.');
    }
}
