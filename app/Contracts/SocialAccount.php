<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 22.10.2019
 * Time: 18:38
 */

namespace App\Contracts;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Socialite\Contracts\User as SocialUser;

interface SocialAccount
{
    /**
     * Find or create user instance by provider name and social user contract.
     *
     * @param string $driver
     * @param SocialUser $socialUser
     *
     * @return Authenticatable
     * @throws AuthorizationException
     * @throws ModelNotFoundException
     */
    public function findOrCreate(string $driver, SocialUser $socialUser): Authenticatable;
}
