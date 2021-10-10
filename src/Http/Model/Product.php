<?php

namespace Payment\Sb\Http\Model;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Payment\Sb\models\Cart;
use Payment\Sb\models\OrderDetail;

class Product extends  Model
{
    protected $guarded=[];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function OrderDetail()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
