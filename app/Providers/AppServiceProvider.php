<?php

namespace App\Providers;

use App\Billing\RazorpayApi;
use App\Models\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('App\Billing\RazorpayApi', function ($app) {
            return new RazorpayApi();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['shop', 'admin.products.create', 'admin.products.index'], function ($view) {
            $view->with('categories', Category::all());
        });
    }
}
