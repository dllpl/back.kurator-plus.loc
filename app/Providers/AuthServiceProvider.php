<?php

namespace App\Providers;

use App\Passport\AuthCode;
use App\Passport\Client;
use App\Passport\PersonalAccessClient;
use App\Passport\Token;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        Passport::useTokenModel(Token::class);
        Passport::useClientModel(Client::class);
        Passport::useAuthCodeModel(AuthCode::class);
        Passport::usePersonalAccessClientModel(PersonalAccessClient::class);

        $expireIn = now()->addDay();
        Passport::tokensExpireIn($expireIn);
        Passport::refreshTokensExpireIn($expireIn);
        Passport::personalAccessTokensExpireIn($expireIn);
        Passport::personalAccessClientId(config('auth.client_id'));
        Passport::enableImplicitGrant();
    }
}
