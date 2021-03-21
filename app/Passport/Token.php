<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 15.08.2019
 * Time: 12:33
 */

namespace App\Passport;

use Laravel\Passport\Token as PassportToken;

class Token extends PassportToken
{
    protected $table = 'oauth.access_tokens';

    protected $dateFormat = 'Y-m-d H:i:sO';
}
