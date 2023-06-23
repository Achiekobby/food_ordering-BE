<?php

namespace App\Http\Resources\General;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Menu;
use App\Models\Restaurant;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $restaurant_id = $this->menu->restaurant_id;
        $restaurant = Restaurant::where('id',$restaurant_id)->first()->address;
        return [
            'id'                    =>$this->id,
            'order_id'              =>$this->order_id,
            'quantity'              =>$this->quantity,
            'unit_amount'           =>'GHS'.number_format((float)$this->unit_amount,2,'.',''),
            'total_amount'          =>'GHS'.number_format((float)$this->total_amount,2,'.',''),
            'payment_status'        =>$this->payment_status,
            'menu_title'            =>$this->menu->title,
            'restaurant_location'   =>$restaurant
        ];
    }
}
