<?php

namespace Sabery\Package\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'name'=>$this->name,
            'description'=>$this->description,
            'status'=>$this->status,
            'price'=>$this->price,
            'final_price'=>$this->final_price
        ];
    }
}
