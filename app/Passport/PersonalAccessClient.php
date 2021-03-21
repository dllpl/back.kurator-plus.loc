<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 15.08.2019
 * Time: 12:33
 */

namespace App\Passport;

use Laravel\Passport\PersonalAccessClient as PassportPersonalAccessClient;

class PersonalAccessClient extends PassportPersonalAccessClient
{
    protected $table = 'oauth.personal_access_clients';

    protected $keyType = 'uuid';

    protected $dateFormat = 'Y-m-d H:i:sO';
}
