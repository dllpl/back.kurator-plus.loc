<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 15.08.2019
 * Time: 12:33
 */

namespace App\Passport;

use Laravel\Passport\AuthCode as PassportAuthCode;

class AuthCode extends PassportAuthCode
{
    protected $table = 'oauth.auth_codes';

    protected $dateFormat = 'Y-m-d H:i:sO';
}
