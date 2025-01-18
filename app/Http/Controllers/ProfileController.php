<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $users = User::where('id', $user->id)->get();
        $jobfield = Job::where('user_id', $user->id)->get();

        $Userfriend = Friend::where('user_id', $user->id)->where('is_accepted', true)->select('friend_id', 'is_accepted')->get();

        return view('profile', compact('users', 'jobfield', 'Userfriend'));
    }

    public function update(Request $request, $id){
        $user = User::findOrFail($id);

        if ($request->hasFile('profilePhoto')) {
            if ($user->profile->profileURL && file_exists(public_path('storage/' . $user->profile->profileURL))) {
                unlink(public_path('storage/' . $user->profile->profileURL));
            }

            $file = $request->file('profilePhoto');
            $path = $file->store('profiles', 'public');

            $user->profile->update(['profileURL' => $path]);
        }

        return redirect()->back();
    }

    public function destroy(string $id){
        $user = Auth::id();

        Friend::where('user_id', $user)->where('friend_id', $id)->where('is_accepted', true)->delete();

        Friend::where('user_id', $id)->where('friend_id', $user)->where('is_accepted', true)->delete();
        
        return redirect()->route('profile.index');
    }
}
