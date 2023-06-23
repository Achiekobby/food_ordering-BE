<?php

namespace App\Http\Resources\General;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\General\OrderItemResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                =>$this->id,
            'amount'            =>'GHS'.number_format((float)$this->amount,2,'.',''),
            'quantity'          =>$this->quantity,
            'payment_status'    =>$this->payment_status,
            'delivery_status'   =>$this->delivery_status,
            'delivery_location' =>$this->delivery_location,
            'order_items'       =>OrderItemResource::collection($this->orderItems)
        ];
    }
}
