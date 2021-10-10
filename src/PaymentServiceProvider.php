<?php

namespace Sabery\Package;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('paymentService',function (){
            return new PaymentService;
        });
    }

    public function boot()
    {
        require __DIR__.'\routes\api.php';

        $this->publishes([
            __DIR__.'/Migrations'=>database_path('/migrations'),

            __DIR__.'/Http/Controllers/ProductController.php'=>base_path('App/Http/Controllers/ProductController.php'),
            __DIR__.'/Http/Controllers/DiscountController.php'=>base_path('App/Http/Controllers/DiscountController.php'),
            __DIR__.'/Http/Controllers/DiscountProductController.php'=>base_path('App/Http/Controllers/DiscountProductController.php'),
            __DIR__.'/Http/Controllers/OrderController.php'=>base_path('App/Http/Controllers/OrderController.php'),
            __DIR__.'/Http/Controllers/OrderDetailController.php'=>base_path('App/Http/Controllers/OrderDetailController.php'),


            __DIR__.'/Http/Resources/CartResource.php'=>base_path('App/Http/Resources/CartResource.php'),
            __DIR__.'/Http/Resources/DiscountProductResource.php'=>base_path('App/Http/Resources/DiscountProductResource.php'),
            __DIR__.'/Http/Resources/DiscountResource.php'=>base_path('App/Http/Resources/DiscountResource.php'),
            __DIR__.'/Http/Resources/OrderDetailResource.php'=>base_path('App/Http/Resources/OrderDetailResource.php'),
            __DIR__.'/Http/Resources/OrderResource.php'=>base_path('App/Http/Resources/OrderResource.php'),
            __DIR__.'/Http/Resources/ProductResource.php'=>base_path('App/Http/Resources/ProductResource.php'),

            __DIR__.'/models/Cart.php'=>base_path('App/Models/Cart.php'),
            __DIR__.'/models/Discount.php'=>base_path('App/Models/Discount.php'),
            __DIR__.'/models/DiscountProduct.php'=>base_path('App/Models/DiscountProduct.php'),
            __DIR__.'/models/OrderDetail.php'=>base_path('App/Models/OrderDetail.php'),
            __DIR__.'/models/Product.php'=>base_path('App/Models/Product.php'),


            __DIR__ . '/config/mine.php' =>config_path('cms.php'),
        ]);
    }
}
