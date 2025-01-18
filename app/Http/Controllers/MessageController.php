<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'receiver_id' => 'required|exists:users,id', 
        ]);

        $senderId = Auth::id();

        Message::create([
            'sender_id' => $senderId,
            'receiver_id' => $request->receiver_id,
            'message' => $request->content,
            'message_delivered' => false,
        ]);

        return redirect()->route('message.show', $request->receiver_id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $userId)
    {
        $authUserId = Auth::id();
       
        $users = Friend::where('friend_id', '=', $authUserId)->where('is_accepted', true)->get();

        $currentChatUser = $userId ? User::find($userId) : null;
        
        $messages = [];
        if ($currentChatUser) {
            $messages = Message::where(function ($query) use ($authUserId, $userId) {
                $query->where('sender_id', $authUserId)
                      ->where('receiver_id', $userId);
            })->orWhere(function ($query) use ($authUserId, $userId) {
                $query->where('sender_id', $userId)
                      ->where('receiver_id', $authUserId);
            })->orderBy('created_at', 'asc')->get();

            foreach ($messages as $message) {
                if ($message->receiver_id == $authUserId && !$message->message_delivered) {
                    $message->update(['message_delivered' => true]);
                }
            }
        }

        return view('message', compact('users', 'currentChatUser', 'messages'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
