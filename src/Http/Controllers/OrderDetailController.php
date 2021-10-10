<?php

namespace Sabery\Package\Http\Controllers;

use App\Http\Controllers\Controller;
use Payment\Sb\Http\Resources\OrderDetailResource;
use Payment\Sb\Http\Resources\OrderResource;
use Payment\Sb\models\Order;
use Payment\Sb\models\OrderDetail;

class OrderDetailController extends Controller
{
    public function index()
    {
        auth()->loginUsingId(2);
        $order=Order::query()->where('user_id',auth()->user()->id)->pluck('id')->toArray();
        $orderDetails=OrderDetail::query()->whereIn('id',$order)->paginate(\request('limit'));
        return response()->json([
            'status'=>'ok',
            'data'=>OrderDetailResource::collection($orderDetails)
        ]);
    }

    public function show($id)
    {
        auth()->loginUsingId(2);
        $order=Order::query()->where('user_id',auth()->user()->id)->pluck('id')->toArray();
        $orderDetails=OrderDetail::query()->whereIn('id',$order)->where('id',$id)->first();
        if ($orderDetails){
            return response()->json([
                'status'=>'ok',
                'data'=>new OrderDetailResource($orderDetails)
            ]);
        }
        else{
            return response()->json([
                'status'=>'Error',
                'massage'=>'شمادست رسی ندارید'
            ],403);
        }
    }
}
