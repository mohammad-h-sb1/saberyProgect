<?php

namespace Sabery\Package\models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function OrderDetail()
    {
        return $this->hasMany(Product::class);
    }

    public function Cars()
    {
        return $this->hasMany(Cart::class);
    }

    public function discountProduct()
    {
        return $this->hasOne(DiscountProduct::class);
    }
}
