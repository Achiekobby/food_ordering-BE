<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::group(['prefix'=>'admin'], function(){
    Route::post('login',[AdminController::class, 'admin_login']);

    Route::middleware('authAdmin')->group(function(){
        Route::post('order/fulfill',[AdminController::class, 'fulfillOrder']);
    });
});
