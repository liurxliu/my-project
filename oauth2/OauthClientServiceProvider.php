<?php

namespace Oauth;

use Illuminate\Support\ServiceProvider;

class OauthClientServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
       $this->app->singleton('google', function($app) {
            return new \Oauth\Providers\GoogleProvider(new \GuzzleHttp\Client, $app->config('services.google'));
       });
       $this->app->singleton('facebook', function($app) {
            return new \Oauth\Providers\FacebookProvider(new \GuzzleHttp\Client, $app->config('services.facebook'));
       });
       $this->app->singleton('github', function($app) {
            return new \Oauth\Providers\GithubProvider(new \GuzzleHttp\Client, $app->config('services.github'));
       });
    }
}
