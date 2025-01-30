<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;

Route::group(['middleware' => 'guest'], function () {
    Route::get('/', [CustomAuthController::class, 'index'])->name('login');
    Route::post('custom_login', [CustomAuthController::class, 'customLogin'])->name('login.custom');
    // Route::get('/forget_password', [CustomAuthController::class, 'forgetPassword'])->name('login.forget_password');
    // Route::post('/forget_password', [CustomAuthController::class, 'forgetPasswordPost'])->name('login.forget_password.update');
    // Route::get('/reset_password/{token}/{email}', [CustomAuthController::class, 'resetPassword'])->name('login.reset_password');
    // Route::post('/reset_password', [CustomAuthController::class, 'resetPasswordPost'])->name('login.reset_password.post');
    // Route::get('/verify/{token}', [CustomAuthController::class, 'verifyAccount'])->name('user.verify'); 

});

Route::group(['middleware' => 'auth'], function () {
    Route::get('dashboard', [CustomAuthController::class, 'dashboard']); 
    Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');
});