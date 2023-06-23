<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\General\UserController;
use App\Http\Controllers\General\OrderController;

Route::group(['prefix'=>'user','middleware'=>['authCheck']],function(){
    Route::get('restaurants', [UserController::class, 'get_all_restaurants']);
    Route::get('restaurant', [UserController::class, 'get_restaurant']);
    Route::get('restaurant/menu', [UserController::class, 'view_restaurant_menu']);

    //*Ordering
    Route::post('make_order',[OrderController::class, 'make_order']);
});
