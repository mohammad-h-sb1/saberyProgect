<?php

namespace Sabery\Package\models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const TYPE_UNPAID='unpaid';
    const TYPE_PAID='paid';
    const TYPE_PREPARATION='preparation';
    const TYPE_POSTED='posted';
    const TYPE_RECEIVED='received';
    const TYPE_CANCELED='canceled';
    const TYPE_FAILED='failed';
    const TYPE_ORDER=[self::TYPE_UNPAID,self::TYPE_PAID,self::TYPE_PREPARATION,self::TYPE_POSTED,self::TYPE_RECEIVED,self::TYPE_CANCELED,self::TYPE_FAILED];
    protected $guarded=[];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class);

    }

    public function OrderDetails()
    {
        return $this->hasOne(OrderDetail::class);
    }
}
