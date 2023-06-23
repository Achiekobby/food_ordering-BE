<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Order;

class AdminController extends Controller
{
    public function admin_login(Request $request){
        try{
            $rules = [
                'email'     =>'required|string|email',
                'password'  =>'required|string|min:8',
            ];
            $validation = Validator::make($request->all(),$rules);
            if($validation->fails()){
                return response()->json(array('status'=>'failed','error'=>$validation->errors()->first()),422);
            }
            $admin = Admin::query()->where('email',$request->email)->first();
            if(!$admin){
                return response()->json(array('status'=>'failed','error'=>'User not found!!'),404);
            }

            if(Hash::check($request->password,$admin->password)){
                $access_token = $admin->createToken('Admin_token_creation')->accessToken;
                return response()->json(
                    [
                        'status'=>'success',
                        'message'=>'Successfully logged in as an admin',
                        'admin'=>$admin,
                        'token'=>$access_token
                    ]
                ,200);
            }
            return response()->json(['status'=>'failed','message'=>'Wrong Credentials'],403);

        }catch(\Exception $e){
            return response()->json(['status'=>'failed','error'=>$e->getMessage()],500);
        }
    }

    //TODO:: Fulfill an order
    public function fulfillOrder(){
        try{
            $admin = auth()->guard('admin')->user();
            if(!$admin){
                return response()->json(['status'=>'failed','error'=>'You must be an admin to access this route'],403);
            }
            $order_id = request()->input('order_id');
            if(!$order_id){
                return response()->json(['status'=>'failed','error'=>'order id must be included as a route parameter for this API'],422);
            }
            $order = Order::query()->where('id',request()->input('order_id'))->where('delivery_status','pending')->first();
            if(!$order){
                return response()->json(['status'=>'failed','error'=>'Order not found or has already been fulfilled'],403);
            }
            $order->update(['delivery_status'=>'delivered']);
            return response()->json(['status'=>'success','message'=>'Order was successfully fulfilled'],200);
        }catch(\Exception $e){
            return response()->json(['status'=>'failed','error'=>$e->getMessage()],500);
        }
    }
}
