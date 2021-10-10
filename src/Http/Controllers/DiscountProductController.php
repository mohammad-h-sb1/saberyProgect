<?php

namespace Sabery\Package\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Payment\Sb\Http\helpers\Helpers;
use Payment\Sb\Http\Resources\DiscountProductResource;
use Payment\Sb\Http\Resources\ProductResource;
use Payment\Sb\models\DiscountProduct;
use Payment\Sb\models\Product;

class DiscountProductController extends Controller
{
    public function index(Request $request)
    {
        $discount_product=DiscountProduct::query()->when($request->input('status')==$request->input('status'),function ($q) use ($request){
            $q->where('status',$request->status);
        })->paginate(\request('limit'));
        if ($request->input('status')){
            return response()->json([
                'status'=>'ok',
                'data'=>DiscountProductResource::collection($discount_product)
            ]);
        }
        else{
            $discount_product=DiscountProduct::query()->orderByDesc('created_at')->paginate(\request('limit'));
            return response()->json([
                'status'=>'ok',
                'data'=>DiscountProductResource::collection($discount_product)
            ]);

        }

    }

    public function create(Request $request,$id)
    {
        $validData=$this->validate($request,[
            'started_at' => 'date_format:Y-m-d H:i',
            'expiration_at' => 'date_format:Y-m-d H:i',
            'discount_type' => 'required',
            'amount' => 'required|integer',
            'status'=>'boolean',
        ]);
        $product=Product::query()->where('id',$id)->first();
        $price=$product->price;
        $apply_discount_product=Helpers::apply_discount_product($price,$request);
        $final_price=$price - $apply_discount_product;
        $data=[
            'product_id'=>$product->id,
            'discount_type'=>$request->discount_type,
            'amount'=>$request->amount,
            'status'=>$request->status,
            'started_at'=>$request->started_at,
            'expiration_at'=>$request->expiration_at
        ];
        $discount_product=DiscountProduct::create($data);

        $product->update([
            'final_price'=>$final_price
        ]);
        return response()->json([
            'status'=>'ok',
            'data'=>new DiscountProductResource($discount_product)
        ],201);
    }

    public function show($id)
    {
        $discount_product=DiscountProduct::query()->where('id',$id)->first();
        return response()->json([
            'status'=>'ok',
            'data'=>new DiscountProductResource($discount_product)
        ]);
    }
    public function edit($id)
    {
        $discount_product=DiscountProduct::query()->where('id',$id)->first();
        return response()->json([
            'status'=>'ok',
            'data'=>new DiscountProductResource($discount_product)
        ]);
    }

    public function update(Request $request,$id)
    {
        $discount_product=DiscountProduct::query()->where('id',$id)->first();
        $product=Product::query()->where('id',$id)->first();
        $price=$product->price;
        $apply_discount_product=Helpers::apply_discount_product($price,$request);
        $final_price=$price - $apply_discount_product;
        $data=[
            'product_id'=>$product->id,
            'discount_type'=>$request->discount_type,
            'amount'=>$request->amount,
            'status'=>$request->status,
            'started_at'=>$request->started_at,
            'expiration_at'=>$request->expiration_at
        ];
        $discount_product->update($data);
        $product->update([
            'final_price'=>$final_price
        ]);
        return response()->json([
            'status'=>'ok',
            'data'=>new DiscountProductResource($discount_product)
        ]);
    }

    public function delete($id)
    {
        $discount_product=DiscountProduct::query()->where('id',$id)->first();
        $product=$discount_product->product;
        $product->update([
            'final_price'=>$product->price
        ]);
        $discount_product->delete();
    }

    public function status($id)
    {
        $discount_product=DiscountProduct::query()->where('id',$id)->first();
        $discount_product->update([
            'status'=>!$discount_product->status
        ]);
        $product=$discount_product->product;
        if ($discount_product->status == 0){
            $product->update([
                'final_price'=>$product->price
            ]);
            return response()->json([
                'status'=>'ok',
                'data'=>new ProductResource($product)
            ]);
        }
        else{
            $request=$discount_product;
            $price=$product->price;
            $apply_discount_product=Helpers::apply_discount_product($price,$request);
            $final_price=$price - $apply_discount_product;

            $product->update([
                'final_price'=>$final_price
            ]);
            return response()->json([
                'status'=>'ok',
                'data'=>new ProductResource($product)
            ]);
        }
    }
}
