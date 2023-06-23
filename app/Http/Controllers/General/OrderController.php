<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//* Models
use App\Models\Order;
use App\Models\OrderItem;

//* Resources
use App\Http\Resources\General\OrderResource;

//* Utilities
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderController extends Controller
{
    //TODO:: PLACING AN ORDER BY SELECTING A MENU FROM A RESTAURANT
    public function make_order(Request $request){
        $rules = [
            'amount'=>'required',
            'quantity'=>'required|integer',
            'order_items'=>'required|array'
        ];

        $validation = Validator::make($request->all(),$rules);
        if($validation->fails()){
            return response()->json(['status'=>'failed','error'=>$validation->errors()->first()],422);
        }

        $user = auth()->guard('api')->user();
        if(!$user){
            return response()->json(['status'=>'failed','error'=>'Sorry, user not found!!'],404);
        }

        $order_transaction = DB::transaction(function() use ($request, $user){
            $order = $user->orders()->updateOrCreate(
                [
                    'user_id'       =>$user->id,
                    'payment_status'=>'not_paid',
                    'paid_at'       =>null
                ],
                [
                    'amount'            =>number_format((float)$request->amount,2,'.',''),
                    'quantity'          =>$request->quantity,
                    'delivery_location' =>$user->address
                ]
            );

            //* creating the corresponding order items
            $order_items = $request->order_items;
            foreach($order_items as $item) {
                $order->orderItems()->updateOrCreate(
                    [
                        'payment_status'=>'not_paid',
                        'menu_id'       =>$item['menu_id']
                    ],
                    [
                        'menu_id'       =>$item['menu_id'],
                        'quantity'      =>$item['quantity'],
                        'unit_amount'   =>number_format((float)$item['unit_amount'],2,'.',''),
                        'total_amount'  =>number_format((float)$item['total_amount'],2,'.',''),
                        'currency'      =>'GHS',
                        'payment_status'=>'not_paid'
                    ]
                );
            }
            return $order;
        });
        if($order_transaction){
            return response()->json(
                [
                    'status' => 'success',
                    'message'=>'Your order has been created. You will be redirected to a page where you can make payment.Thank you',
                    'order_details'=>new OrderResource($order_transaction)
                ],200
            );
        }
        return response()->json(['status'=>'failed','message'=>'Sorry, you order could not be made. please try again later!!'],400);

    }

    //TODO:: HANDLING ORDER FULFILLMENT
}
