<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

//use App\News\NewsAPIService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
//    public function register()
//    {
//        $this->app->bind(NewsAPIService::class, function () {
//            return new NewsAPIService();
//        });
//    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
