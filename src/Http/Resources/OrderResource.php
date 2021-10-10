<?php

namespace Sabery\Package\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'user'=>$this->user,
            'discount'=>new DiscountResource($this->discount),
            'amount'=>$this->amount,
            'discount_amount'=>$this->discount_amount,
            'total_amount'=>$this->total_amount,
            'status'=>$this->status
        ];
    }
}
