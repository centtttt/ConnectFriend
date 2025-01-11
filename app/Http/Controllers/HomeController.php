<?php

namespace App\Http\Controllers;

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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
