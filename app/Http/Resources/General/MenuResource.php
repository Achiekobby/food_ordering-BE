<?php

namespace App\Http\Resources\General;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
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
            'title'         =>$this->title,
            'slug'          =>$this->slug,
            'summary'       =>$this->summary,
            'type'          =>$this->type,
            'price'         =>'GHS.'.number_format((float)($this->price),2,'.',''),
            'discount_amount'=>'GHS.'.number_format((float)($this->discount),2,'.','')
        ];
    }
}
