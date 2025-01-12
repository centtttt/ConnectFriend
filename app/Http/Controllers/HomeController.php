<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\Job;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $inputSearch = $request->input('fieldSearch');
        $filterSearch = $request->input('genderFilter');
        $loggedInUserId = Auth::user();

        $query = User::join('profile as p', 'p.user_id', '=', 'users.id')
                    ->join('jobfield as jf', 'jf.user_id', '=', 'users.id')->select('users.*', 'p.gender');

        if (Auth::check()) {
            $loggedInUserId = Auth::user();
            $query->where('users.id', '!=', $loggedInUserId->id);
        }

        if ($filterSearch) {
            $query->where('p.gender', $filterSearch);
        }

        if ($inputSearch) {
            $query->where('jf.jobfieldname', 'like', '%' . $inputSearch . '%');
        }

        $dataUsers = $query->distinct()->get();
        $jobfields = Job::all();

        return view('home', compact('dataUsers', 'jobfields'));
    }

    public function create()
    {
        //
    }

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

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }
}
