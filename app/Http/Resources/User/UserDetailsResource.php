<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            =>$this->id,
            'first_name'    =>$this->first_name,
            'last_name'     =>$this->last_name,
            'email'         =>$this->email,
            'phone_number'  =>$this->phone_number,
            'city'          =>$this->city,
            'address'       =>$this->address,
            'email_verified_at'=>$this->email_verified_at,
        ];
    }
}
