<?php

namespace App\Providers;

use App\Http\Lib\Billing\UFCPayment;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton("payment:vtb", function() {
            return new UFCPayment(\Storage::disk('local')->path('cert/cert-prod.pem'), "BelinQed2020!", "https://ecommerce.ufc.ge:18443/ecomm2/MerchantHandler", "https://ecommerce.ufc.ge/ecomm2/ClientHandler");
        });

    }
}
