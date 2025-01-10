<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index(){
        $payment = Payment::where('user_id', Auth::id())->latest()->first();

        return view('payment', compact('payment'));
    }

    public function payment(Request $request){
        $price = Payment::where('user_id', Auth::id())->latest()->first();
        $minimumPrice = $price->registration_price;
        $amount = $request->input('amount');

        if ($amount < $minimumPrice) {
            $underpaid = $minimumPrice - $amount;
            return redirect()->back()->with('error', "You are still underpaid " . $underpaid . ".");
        }

        if ($amount > $minimumPrice) {
            $overpaid = $amount - $minimumPrice;
            return redirect()->back()->with('error', "Sorry you overpaid " . $overpaid . ". " . "Would you like to enter a balance? We will enter the rest of your money in the wallet balance.")->with('overpaid', $overpaid);
        }

        if($price){
            $price->payment_status = true;
            $price->save();
        }

        $user = Auth::user();
        $user->has_paid = true;
        $user->save();
        
        return redirect()->route('home')->with('status', 'Payment successful! Thank you.');
    }

    public function handleoverpayment(Request $request)
    {
        $action = $request->input('action');
        $overpaidAmount = $request->input('overpaid_amount');

        if ($action === 'yes') {
            $profile = Profile::where('user_id', Auth::id())->latest()->first();
            $payment = Payment::where('user_id', Auth::id())->latest()->first();

            if($profile){
                $profile->coins += $overpaidAmount;
                $profile->save();
            }

            if($payment){
                $payment->payment_status = true;
                $payment->save();
            }

            $user = Auth::user();
            $user->has_paid = true;
            $user->save();

            return redirect()->route('home')->with('status', "Payment successful! Overpaid amount " . $overpaidAmount . " has been added to your wallet.");
        }

        if ($action === 'no') {
            return redirect()->route('payment')->with('error', "Please re-enter your payment amount.");
        }
    }
}
