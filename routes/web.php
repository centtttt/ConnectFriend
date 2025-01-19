<?php

use App\Http\Controllers\AvatarController;
use App\Http\Controllers\FriendProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\TopUpController;
use Illuminate\Support\Facades\Route;
Use Illuminate\Support\Facades\Auth;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::resource('/home', HomeController::class);

Route::middleware(['auth', 'checkStatus'])->group(function(){
    Route::resource('/profile', ProfileController::class);
    Route::resource('/friend-profile', FriendProfileController::class);
    Route::resource('/message', MessageController::class);
    Route::resource('/notification', NotificationController::class);
    Route::resource('/topup', TopUpController::class);
});

Route::middleware(['auth', 'checkUserStatus'])->group(function(){
    Route::get('/registration', [RegistrationController::class, 'index'])->name('registration');
    Route::post('/createregistration', [RegistrationController::class, 'register'])->name('createregistration');
});

Route::middleware(['auth', 'checkPaymentStatus'])->group(function(){
    Route::get('/payment', [PaymentController::class, 'index'])->name('payment');
    Route::post('/createpayment', [PaymentController::class, 'payment'])->name('createpayment');
    Route::post('/overpayment', [PaymentController::class, 'handleoverpayment'])->name('overpayment');
});

Route::get('/set-locale/{locale}', function($locale){
    if(in_array($locale, ['en', 'id'])){
        session(['locale' => $locale]);
    }
    
    return redirect()->back(); 
})->name('set-locale');

Auth::routes();