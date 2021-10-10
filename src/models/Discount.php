<?php

namespace Sabery\Package\models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $guarded=[];
    const TYPE_PERCENT='percent';
    const TYPE_CASH='cash';
    const TYPE_DISCOUNT=[self::TYPE_PERCENT,self::TYPE_CASH];
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

}
