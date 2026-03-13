<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\Gateway\FakePayController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


//Merchant payment 
Route::get('/payment/{order}', [PaymentController::class,'paymentPage'])->name('payment.page');

Route::get('/payment/success/{order}', [PaymentController::class,'paymentSuccess'])->name('payment.success');

Route::get('/payment/fail/{order}', [PaymentController::class,'paymentFail'])->name('payment.fail');
Route::get('/payment-result', [PaymentController::class,'paymentResult'])->name('payment.result');

Route::prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index']);

    Route::get('/login', function () {
        return view('auth/signin');
    })->name('login');

    Route::post('/login_user', [LoginController::class, 'loginUser']);


    Route::get('/logout', function () {
        Auth::logout();
        return redirect()->route('login');
    })->name('logout');

    // other admin routes...
});

Route::get('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');

Route::view('/front', 'frontend.index');



//universal for vue 

Route::get('/{vue_capture}', function () {
    return view('frontend.index');
})->where('vue_capture', '^(?!admin).*');
