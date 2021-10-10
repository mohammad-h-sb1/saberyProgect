<?php

namespace Sabery\Package\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Payment\Sb\Http\helpers\Helpers;
use Payment\Sb\Http\Model\Product;
use Payment\Sb\Http\Resources\OrderDetailResource;
use Payment\Sb\Http\Resources\OrderResource;
use Payment\Sb\models\Cart;
use Payment\Sb\models\Discount;
use Payment\Sb\models\Order;
use Payment\Sb\models\OrderDetail;

class OrderController extends Controller
{
    /**
     *index
     */
    public function index()
    {
        auth()->loginUsingId(1);
        $order=Order::query()->where('user_id',auth()->user()->id)->where('status','!=','failed')->paginate(\request('limit'));
        return response()->json([
            'status'=>'ok',
            'data'=>OrderResource::collection($order)
        ]);
    }

    /**
     *create
     */
    public function create(Request $request)
    {
        auth()->loginUsingId(1);
        $validData=$this->validate($request,[
            'discount_code'=>'string|nullable',
        ]);
        $discount=Discount::query()->where('code',$request->input('discount_code'))->first();
        $carts=Cart::query()->where('user_id',auth()->user()->id)->get();
        if ($discount){
            $data=[
                'user_id'=>auth()->user()->id,
                'discount_id'=>$discount->id
            ];
        }
        else{
            $data=[
                'user_id'=>auth()->user()->id
            ];
        }
        $order=Order::create($data);
        foreach ($carts as $cart){
            $product=$cart->product->final_price;
            $count=$cart->count;
            $amount=$product * $count;
            $dataOrder=[
                'order_id'=>$order->id,
                'product_id'=>$cart->product_id,
                'count'=>$cart->count,
                'price'=>$cart->product->price,
                'total_amount'=>$amount
            ];
            OrderDetail::create($dataOrder);
            $cart->delete();
        }
        $orderDetail=OrderDetail::query()->where('order_id',$order->id)->get();
        $amountOrder=$orderDetail->sum('total_amount');
        $apply_discount=0;
        if ($discount){
            if ($discount->started_at < now())
            {
                if ($discount->expiration_at > now())
                {
                    $apply_discount=Helpers::apply_discount($discount,$amountOrder);
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
        $total_amount_order=$amountOrder - $apply_discount;
        $order->update([
            'amount'=>$amountOrder,
            'discount_amount'=>$apply_discount,
            'total_amount'=>$total_amount_order
        ]);
        return response()->json([
            'status'=>'ok',
            'data'=>OrderDetailResource::collection($orderDetail)
        ],201);


    }

    /**
     *show
     */
    public function show($id)
    {
        auth()->loginUsingId(1);
        $order=Order::query()->where('id',$id)->where('user_id',auth()->user()->id)->first();
        if ($order){
            return response()->json([
                'status'=>'ok',
                'data'=>new OrderResource($order)
            ]);
        }
        else{
            return response()->json([
                'status'=>'Error',
                'massage'=>'شمادسترسی ندراید'
            ],403);
        }
    }


    /**
     *delete
     */
    public function delete($id)
    {
        auth()->loginUsingId(2);
        $order=Order::query()->where('id',$id)->where('user_id',auth()->user()->id)->first();
        if ($order){
            if ($order->status == 'unpaid')
            {
                $order->delete();
            }
            else
            {
                return response()->json([
                    'status'=>'Error',
                    'massage'=>'شمادسترسی ندراید'
                ],403);
            }
        }
        else
        {
            return response()->json([
                'status'=>'Error',
                'massage'=>'شمادسترسی ندراید'
            ],403);
        }

    }

    public function paymentStatus(Request $request)
    {
        $validData=$this->validate($request,[
            'paid'=>'nullable|boolean',
            'unpaid'=>'nullable|boolean',
            'preparation'=>'nullable|boolean',
            'posted'=>'nullable|boolean',
            'received'=>'nullable|boolean',
            'canceled'=>'nullable|boolean',
        ]);
        auth()->loginUsingId(2);
        $order=Order::query()->where('user_id',auth()->user()->id)
            ->when($request->input('paid')==1,function ($q) use ($request){
                return $q->where('status','paid');
            })->when($request->input('unpaid')==1,function ($q) use ($request){
                return $q->where('status','unpaid');
            })->when($request->input('preparation')==1,function ($q) use ($request){
                return $q->where('status','preparation');
            })->when($request->input('posted')==1,function ($q) use ($request){
                return $q->where('status','posted');
            })->when($request->input('received')==1,function ($q) use ($request){
                return $q->where('status','received');
            })->when($request->input('canceled')==1,function ($q) use ($request){
                return $q->where('status','canceled');
            })
            ->paginate(\request('limit'));

        return response()->json([
            'status'=>'ok',
            'data'=>OrderResource::collection($order)
        ]);
    }
}
