<?php

use Illuminate\Support\Facades\Route;

//* Authentication Controllers
use App\Http\Controllers\Auth\AuthenticationController;

Route::group(['prefix'=>'auth'], function(){

    //* Register route
    Route::post('register',[AuthenticationController::class, 'register'])->name('auth.register');

    //* Login route
    Route::post('login',[AuthenticationController::class, 'login'])->name('auth.login');

});
