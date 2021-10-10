<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Sabery\Package\Http\Controllers\CartController;
use Sabery\Package\Http\Controllers\DiscountController;
use Sabery\Package\Http\Controllers\DiscountProductController;
use Sabery\Package\Http\Controllers\OrderController;
use Sabery\Package\Http\Controllers\OrderDetailController;
use Sabery\Package\Http\Controllers\ProductController;

Route::prefix('product')->group(function (){
    Route::get('list',[ProductController::class,'index']);
    Route::post('/create',[ProductController::class,'create']);
    Route::get('/show/{id}',[ProductController::class,'show']);
    Route::get('/edit/{id}',[ProductController::class,'edit']);
    Route::put('/update/{id}',[ProductController::class,'update']);
    Route::delete('/delete/{id}',[ProductController::class,'delete']);

    //محصولات فروخته شده
    Route::get('products/sold',[ProductController::class,'productsSold']);
});

Route::prefix('cart')->group(function (){
    Route::get('list',[CartController::class,'index']);
    Route::post('create',[CartController::class,'create']);
    Route::get('show/{id}',[CartController::class,'show']);
    Route::get('edit/{id}',[CartController::class,'edit']);
    Route::put('update/{id}',[CartController::class,'update']);
    Route::delete('delete/{id}',[CartController::class,'delete']);
});

Route::prefix('order')->group(function (){
    Route::get('list',[OrderController::class,'index']);
    Route::post('create',[OrderController::class,'create']);
    Route::get('show/{id}',[OrderController::class,'show']);
    Route::delete('delete/{id}',[OrderController::class,'delete']);
    Route::get('payment/status',[OrderController::class,'paymentStatus']);
});


Route::prefix('order/detail')->group(function (){
    Route::get('list',[OrderDetailController::class,'index']);
    Route::get('show/{id}',[OrderDetailController::class,'show']);
});

Route::prefix('discounts')->group(function (){
    Route::get('list',[DiscountController::class,'index']);
    Route::post('create',[DiscountController::class,'create']);
    Route::get('show/{id}',[DiscountController::class,'show']);
    Route::get('edit/{id}',[DiscountController::class,'edit']);
    Route::put('update/{id}',[DiscountController::class,'update']);
    Route::delete('delete/{id}',[DiscountController::class,'delete']);

});

Route::prefix('discounts/product')->group(function (){
    Route::get('list',[DiscountProductController::class,'index']);
    Route::post('create/{id}',[DiscountProductController::class,'create']);
    Route::get('show/{id}',[DiscountProductController::class,'show']);
    Route::get('edit/{id}',[DiscountProductController::class,'edit']);
    Route::put('update/{id}',[DiscountProductController::class,'update']);
    Route::delete('delete/{id}',[DiscountProductController::class,'delete']);
    Route::post('status/{id}',[DiscountProductController::class,'status']);

});


