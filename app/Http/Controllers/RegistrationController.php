<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Payment;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    public function index(){
        $price = rand(100000, 125000);
        return view('registration', compact('price'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'gender' => 'required|in:Male,Female',
            'options' => 'required|array|min:3',
            'options.*' => 'required|string',
            'linkedinusername' => 'required|regex:/^https:\/\/www\.linkedin\.com\/in\/[a-zA-Z0-9_-]+$/',
            'mobilenumber' => 'required|digits_between:10,15',
            'reference' => 'required|string',
            'price' => 'required|integer',
        ]);
        
        if (count($request->options) !== count(array_unique($request->options))) {
            return redirect()->back()->withErrors(['options' => 'Options must not contain duplicate values.'])->withInput();    
        }

        Profile::create([
            'user_id' => Auth()->id(),
            'gender' => $request->gender,
            'linkedin' => $request->linkedinusername,
            'mobile_number' => $request->mobilenumber,
            'reference' => $request->reference,
        ]);

        Payment::create([ 
            'user_id' => Auth()->id(),
            'registration_price' => $request->price,
        ]);

        foreach ($request->options as $option) {
            Job::firstOrCreate([
                'user_id' => Auth()->id(),
                'jobfieldname' => $option
            ]);
        }
        
        $user = Auth::user();
        $user->is_registered = true;
        $user->save();
        return redirect()->route('payment');
    }
}
