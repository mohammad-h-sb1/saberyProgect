<?php

namespace Payment\Sb\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DiscountResource extends JsonResource
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
            'code'=>$this->code,
            'discount_type'=>$this->discount_type,
            'amount'=>$this->amount,
            'status'=>$this->status,
            'started_at'=>$this->started_at,
            'expiration_at'=>$this->expiration_at
        ];
    }
}
