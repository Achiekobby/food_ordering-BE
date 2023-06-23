<?php

namespace App\Http\Resources\General;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\General\MenuResource;

class RestaurantResource extends JsonResource
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
            'restaurant_name'   =>$this->name,
            'slug'              =>$this->slug,
            'city'              =>$this->city,
            'address'           =>$this->address,
            'menus'             =>MenuResource::collection($this->whenLoaded('menus'))
        ];
    }
}
