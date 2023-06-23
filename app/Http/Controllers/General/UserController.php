<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//* Models
use App\Models\Restaurant;

//* Resources
use App\Http\Resources\General\RestaurantResource;
use App\Http\Resources\General\MenuResource;

class UserController extends Controller
{
    //TODO:: BROWSE RESTAURANTS
    public function get_all_restaurants(){
        try{
            $restaurants = Restaurant::query()->get();
            if(!$restaurants){
                return response()->json(['status'=>'failed','message'=>'No restaurant in the system yet!'],404);
            }
            return response()->json(['status'=>'success','restaurants'=>RestaurantResource::collection($restaurants)],200);

        }catch(\Exception $e){
            return response()->json(['status'=>'failed','error'=>$e->getMessage()]);
        }
    }

    //TODO:: RETRIEVE DETAILS OF A SELECTED RESTAURANTS
    public function get_restaurant(){
        try{
            $restaurant =Restaurant::query()->with('menus')->where('slug',request()->input('slug'))->first();
            if(!$restaurant){
                return response()->json(['status'=>'failed','message'=>'No restaurant found'],404);
            }
            return response()->json(['status'=>'success','restaurant'=>new RestaurantResource($restaurant)],200);

        }catch(\Exception $e){
            return response()->json(['status'=>'failed','error'=>$e->getMessage()]);
        }
    }

    //TODO:: VIEW MENUS FOR SELECTED RESTAURANT
    public function view_restaurant_menu(){
        try{
            $slug = request()->input('slug');
            $restaurant = Restaurant::query()->where('slug',$slug)->first();
            $menus = $restaurant->menus;
            if(count($menus)===0){
                return response()->json(['status'=>'failed','message'=>'Sorry, This restaurant has not uploaded a menu yet!'],404);
            }
            return response()->json(['status'=>'success','menu'=>MenuResource::collection($menus)],200);

        }catch(\Exception $e){
            return response()->json(['status'=>'failed','error'=>$e->getMessage()],500);
        }
    }

}
