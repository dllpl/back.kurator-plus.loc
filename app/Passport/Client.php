<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 15.08.2019
 * Time: 12:33
 */

namespace App\Passport;

use Laravel\Passport\Client as PassportClient;

class Client extends PassportClient
{
    protected $table = 'oauth.clients';

    protected $keyType = 'uuid';

    protected $dateFormat = 'Y-m-d H:i:sO';

    /**
     * @return bool
     */
    public function skipsAuthorization(): bool
    {
        return $this->id === config('auth.client_id');
    }
}
