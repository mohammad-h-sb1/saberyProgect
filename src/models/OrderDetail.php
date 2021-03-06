<?php

namespace Sabery\Package\models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $guarded=[];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
