<?php

namespace Sabery\Package\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Payment\Sb\Http\Resources\CartResource;
use Payment\Sb\models\Cart;

class CartController extends Controller
{
    /**
     *index
     */
    public function index()
    {
        auth()->loginUsingId(52);
        $cart=Cart::query()->where('user_id',auth()->user()->id)->paginate(\request('limit'));
        return response()->json([
            'status'=>'ok',
            'data'=>CartResource::collection($cart)
        ]);
    }

    /**
     *create
     */
    public function create(Request $request)
    {
        auth()->loginUsingId(2);
        $validData=$this->validate($request,[
            'count'=>'integer',
            'product_id'=>'required|integer'
        ]);
        $data=[
            'user_id'=>auth()->user()->id,
            'product_id'=>$request->input('product_id'),
            'count'=>$request->count,
        ];
        $cart=Cart::create($data);
        return response()->json([
            'status'=>'ok',
            'data'=>new CartResource($cart)
        ],201);
    }

    /**
     *show
     */
    public function show($id)
    {
        auth()->loginUsingId(2);
        $cart=Cart::query()->where('id',$id)->where('user_id',auth()->user()->id)->first();
        if ($cart){
            return response()->json([
                'status'=>'ok',
                'data'=>new CartResource($cart)
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
     *edit
     */
    public function edit($id)
    {
        auth()->loginUsingId(2);
        $cart=Cart::query()->where('id',$id)->where('user_id',auth()->user()->id)->first();
        if ($cart){
            return response()->json([
                'status'=>'ok',
                'data'=>new CartResource($cart)
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
     * Transform the resource into an array.
     *update
     */
    public function update(Request $request ,$id)
    {
        auth()->loginUsingId(2);
        $cart=Cart::query()->where('id',$id)->where('user_id',auth()->user()->id)->first();
        if ($cart){
            $validData=$this->validate($request,[
                'count'=>'integer',
                'product_id'=>'required|integer'
            ]);
            $cart->update($validData);
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
    public function delete(Request $request ,$id)
    {
        auth()->loginUsingId(2);
        $cart=Cart::query()->where('id',$id)->where('user_id',auth()->user()->id)->first();
        if ($cart){
            $cart->delete();
        }

        else{
            return response()->json([
                'status'=>'Error',
                'massage'=>'شمادسترسی ندراید'
            ],403);
        }
    }


}
