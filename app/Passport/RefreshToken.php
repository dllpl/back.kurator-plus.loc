<?php
/**
 * Created by PhpStorm.
 * User: V.A.I
 * Date: 23.08.2019
 * Time: 14:45
 */

namespace App\Passport;

use App\Models\Model;

class RefreshToken extends Model
{
    protected $table = 'oauth.refresh_tokens';
}
