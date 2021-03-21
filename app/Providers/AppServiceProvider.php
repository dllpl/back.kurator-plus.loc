<?php

namespace App\Providers;

use DB;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * All of the container bindings that should be registered.
     *
     * @var array
     */
    public $bindings = [
        // bind RefreshTokenRepository to our own
        \Laravel\Passport\Bridge\RefreshTokenRepository::class => \App\Passport\Bridge\RefreshTokenRepository::class,
        \App\Contracts\SocialAccount::class => \App\Services\SocialAccountService::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Passport::ignoreMigrations();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (config('app.debug', false)) {
            DB::enableQueryLog();
        }
    }
}
