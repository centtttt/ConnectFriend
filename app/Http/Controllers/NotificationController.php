<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = Auth::id();
        $friend = Friend::where('friend_id', $user_id)->where('is_accepted', false)->get(); 
       
        $users = Friend::where('friend_id', $user_id)->where('is_accepted', true)->get();

        $messages = Message::where(function ($query) use ($user_id) {
            $query->where('sender_id', $user_id)
                  ->where('message_delivered', false)
                  ->where('sender_id', '!=', $user_id);
        })
        ->orWhere(function ($query) use ($user_id) {
            $query->where('receiver_id', $user_id)
                  ->where('message_delivered', false);
        })->with('receiver')->get();

        return view('notification', compact('friend', 'messages', 'users'));
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
        $userId = Auth::id();
        $friendId = $request->friend_id;

        $existingFriend = Friend::where('user_id', $userId)
                                ->where('friend_id', $friendId)
                                ->first();

        if (!$existingFriend) {
            Friend::create([
                'user_id' => $userId,
                'friend_id' => $friendId,
                'is_accepted' => false,
            ]);
        }

        $reciprocalRequest = Friend::where('user_id', $friendId)
                                   ->where('friend_id', $userId)
                                   ->first();

        if ($reciprocalRequest) {
            $reciprocalRequest->update(['is_accepted' => true]);
            $existingFriend2 = Friend::where('user_id', $userId)
                  ->where('friend_id', $friendId)
                  ->first();

            if ($existingFriend2) {
                $existingFriend2->update(['is_accepted' => true]);
            }

            if ($reciprocalRequest->is_accepted && $existingFriend2 && $existingFriend2->is_accepted) {
                return redirect()->back()->with('success', 'You are connected as friends!');
            }
        }

        return redirect()->back()->with('success', 'Friend request sent!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $userId)
    {

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
    public function destroy(string $friend)
    {
        Friend::where('friend_id', $friend)->where('is_accepted', false)->delete();
        
        return redirect()->back()->with('success', 'Friend request successfully rejected.');
    }
}
