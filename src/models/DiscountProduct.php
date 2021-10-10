<?php

namespace Sabery\Package\models;

use Illuminate\Database\Eloquent\Model;

class DiscountProduct extends Model
{
    protected $table='discount_products';
    protected $guarded=[];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
