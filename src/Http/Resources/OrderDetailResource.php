<?php

namespace Sabery\Package\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
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
            'order'=>new OrderResource($this->order),
            'product_id'=>new ProductResource($this->product),
            'count'=>$this->count,
            'price'=>$this->price,
            'total_amount'=>$this->total_amount
        ];
    }
}
