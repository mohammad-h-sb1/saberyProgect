<?php

namespace Sabery\Package\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Payment\Sb\Http\Model\Product;
use Payment\Sb\Http\Resources\OrderDetailResource;
use Payment\Sb\Http\Resources\ProductResource;
use Payment\Sb\models\OrderDetail;


class ProductController extends Controller
{
    public function index()
    {
        $product=Product::query()->where('status',1)->paginate(\request('limit'));
        return response()->json([
            'status'=>'ok',
            'data'=>ProductResource::collection($product)
        ]);
    }

    public function create(Request $request)
    {
        auth()->loginUsingId(1);
        $validData=$this->validate($request,[
            'name'=>'required|string|',
            'status'=>'boolean|nullable',
            'price'=>'required|integer ',
            'description'=>'nullable|string',
        ]);
        $data=[
            'user_id'=>auth()->user()->id,
            'name'=>$validData['name'],
            'description'=>$request->input('description'),
            'price'=>$validData['price'],
            'final_price'=>$validData['price'],
            'status'=>$request->input('status')
        ];
        $product=Product::create($data);
        return response()->json([
            'status'=>'ok',
            'data'=>new ProductResource($product)
        ],201);
    }

    public function show($id)
    {
        $product=Product::query()->where('id',$id)->first();
        return response()->json([
            'status'=>'ok',
            'data'=>new ProductResource($product)
        ]);
    }

    public function edit($id)
    {
        auth()->loginUsingId(2);
        $product=Product::query()->where('id',$id)->first();
        if ($product->user_id == auth()->user()->id){
            return response()->json([
                'status'=>'ok',
                'data'=>new ProductResource($product)
            ]);
        }
        else{
            return response()->json([
                'status'=>'Error',
                'massage'=>'شمادسترسی ندراید'
            ],403);
        }
    }
    public function update(Request $request,$id)
    {
        auth()->loginUsingId(2);
        $product=Product::query()->where('id',$id)->first();
        if ($product->user_id == auth()->user()->id){
            $validData=$this->validate($request,[
                'name'=>'required|string|',
                'status'=>'boolean|nullable',
                'price'=>'required|integer ',
                'description'=>'nullable|string'
            ]);
            $product->update($validData);
        }
        else{
            return response()->json([
                'status'=>'Error',
                'massage'=>'شمادسترسی ندراید'
            ],403);
        }
    }
    public function delete(Request $request,$id)
    {
        auth()->loginUsingId(2);
        $product=Product::query()->where('id',$id)->first();
        if ($product->user_id == auth()->user()->id){
            $product->delete();
        }
        else{
            return response()->json([
                'status'=>'Error',
                'massage'=>'شمادسترسی ندراید'
            ],403);
        }
    }

    public function productsSold()
    {
        auth()->loginUsingId(1);
        $product=Product::query()->where('user_id',auth()->user()->id)->pluck('id')->toArray();
        $OrderDetails=OrderDetail::query()->whereIn('product_id',$product)->orderByDesc('created_at')->get();
        foreach ($OrderDetails as $orderDetail){
            $order=$orderDetail->order;
        }
        $total_amount=$order->sum('total_amount');
        return response()->json([
            'status'=>'ok',
            'data'=>[
                'orderDetail'=>OrderDetailResource::collection($OrderDetails),
                'total_amount'=>$total_amount
            ]
        ]);
    }
}
