<?php

namespace Sabery\Package\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DiscountProductResource extends JsonResource
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
            'product'=>new ProductResource($this->product),
            'discount_type'=>$this->discount_type,
            'amount'=>$this->amount,
            'status'=>$this->status,
            'expiration_at'=>$this->expiration_at
        ];
    }
}
