<?php

namespace Payment\Sb\Http\helpers;

use Carbon\Carbon;

class Helpers
{
    public static function checkCode($discount)
    {
        if ($discount->started_at < now())
        {
            if ($discount->expiration_at > now())
            {
                return response()->json([
                    'status'=>'ok',
                    'massage'=>'کد شما معتبر است'
                ]);
            }
            else
            {
                return response()->json([
                    'status'=>'Error',
                    'massage'=>'کد شما معتبر نیست'
                ]);
            }
        }
        else
        {
            return response()->json([
                'status'=>'Error',
                'massage'=>'کد شما معتبر نیست'
            ]);
        }
    }

    public static function apply_discount($discount,$amountOrder)
    {

        if ($discount->discount_type == 'percent'){
            $discount_rate=$discount->amount;
            $discount_amount=($amountOrder*$discount_rate)/100;
            if ($discount_amount > $discount->max_amount ){
                return  $discount->max_amount;
            }
            return $discount_amount;
        }
        else{
            return $discount->amount;

        }
    }

    public static function apply_discount_product($price,$request)
    {
        if ($request->discount_type == 'percent'){
            $discount_amount=($price * $request->amount)/100;
            return $discount_amount;
        }
        else{
            return $request->amount;
        }
    }
}
