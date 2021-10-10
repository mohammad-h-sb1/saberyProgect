<?php

namespace Sabery\Package\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Payment\Sb\Http\Resources\DiscountResource;
use Payment\Sb\models\Discount;

class DiscountController extends Controller
{
    public function index()
    {

    }

    public function create(Request $request)
    {
        $validData=$this->validate($request,[
            'code'=>'required|string|unique:discounts',
            'started_at' => 'required|date_format:Y-m-d H:i',
            'expiration_at' => 'required|date_format:Y-m-d H:i',
            'discount_type' => 'required',
            'amount' => 'required|integer',
            'max_amount' => 'integer',
            'status'=>'boolean',
            ]);
        $data=[
            'code'=>$request->code,
            'started_at'=>$request->started_at,
            'expiration_at'=>$request->expiration_at,
            'discount_type'=>$request->discount_type,
            'amount'=>$request->amount,
            'max_amount'=>$request->max_amount,
            'status'=>$request->status
        ];
        $discount=Discount::create($data);
        return response()->json([
            'status'=>'ok',
            'data'=>new DiscountResource($discount)
        ]);
    }

    public function show($id)
    {
        $discount=Discount::query()->where('id',$id)->first();
        return response()->json([
            'status'=>'ok',
            'data'=>new DiscountResource($discount)
        ]);
    }
    public function edit($id)
    {
        $discount=Discount::query()->where('id',$id)->first();
        return response()->json([
            'status'=>'ok',
            'data'=>new DiscountResource($discount)
        ]);
    }

    public function update(Request $request,$id)
    {
        $discount=Discount::query()->where('id',$id)->first();
        $validData=$this->validate($request,[
            'code'=>['string',Rule::unique('discounts','code')->ignore($discount->id)],
            'started_at' => 'date_format:Y-m-d H:i',
            'expiration_at' => 'date_format:Y-m-d H:i',
            'discount_type' => 'string',
            'amount' => '|integer',
            'status'=>'boolean',
        ]);
        $discount->update($validData);
    }

    public function delete($id)
    {
        $discount=Discount::query()->where('id',$id)->first();
        $discount->delete();
    }

}
