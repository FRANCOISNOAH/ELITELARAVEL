<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


/**
 * Authentification Route
 */

Route::get('',[\App\Http\Controllers\AuthController::class,'login'])->middleware('guest')->name('login');
Route::get('register',[\App\Http\Controllers\AuthController::class,'register'])->middleware('guest')->name('register');
Route::post('register',[\App\Http\Controllers\AuthController::class,'saveregister'])->middleware('guest')->name('post.register');
Route::get('confirmregister',[\App\Http\Controllers\AuthController::class,'confirmregister'])->middleware('guest')->name('confirm.register');
Route::post('postlogin', [\App\Http\Controllers\AuthController::class, 'email'])->middleware('guest')->name('login.post');
Route::get('password', [\App\Http\Controllers\AuthController::class, 'loginpassword'])->middleware('guest')->name('password');
Route::post('password', [\App\Http\Controllers\AuthController::class, 'connect'])->middleware('guest')->name('password.post');
Route::get('forgot_password/{email}',[\App\Http\Controllers\AuthController::class,'forgot_password'])->middleware('guest')->name('password.request');
Route::post('forget_password', [\App\Http\Controllers\AuthController::class, 'submitForgetPasswordForm'])->middleware('guest')->name('password.email');
Route::get('reset-password/{token}', [\App\Http\Controllers\AuthController::class, 'showResetPasswordForm'])->middleware('guest')->name('password.reset');
Route::post('reset-password', [\App\Http\Controllers\AuthController::class, 'submitResetPasswordForm'])->middleware('guest')->name('password.update');
Route::get('reset_confirmation',[\App\Http\Controllers\AuthController::class,'confirm'])->middleware('guest')->name('password.confirm');
Route::delete('logout',[\App\Http\Controllers\AuthController::class,'destroy'])->name('logout');


/**
 * Adminstration Route
 */
Route::middleware(['auth'])->group(function (){
    Route::resource('operation',\App\Http\Controllers\OperationController::class);
    Route::resource('user',\App\Http\Controllers\UserController::class);
    Route::resource('company',\App\Http\Controllers\CompanyController::class);
});



