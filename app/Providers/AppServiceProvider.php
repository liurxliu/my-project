<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
       $this->app->singleton('google', function($app) {
            return new \Oauth\Providers\GoogleProvider(new \GuzzleHttp\Client, app('config')['services.google']);
       });
       $this->app->singleton('facebook', function($app) {
            return new \Oauth\Providers\FacebookProvider(new \GuzzleHttp\Client, app('config')['services.facebook']);
       });
       $this->app->singleton('github', function($app) {
            return new \Oauth\Providers\GithubProvider(new \GuzzleHttp\Client, app('config')['services.github']);
       });
    }
}
