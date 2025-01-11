<?php

namespace App\Http\Controllers;

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

        return view('profile', compact('users', 'jobfield'));
    }
}
