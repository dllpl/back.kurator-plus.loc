<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 30.08.2019
 * Time: 12:02
 */

namespace App\GraphQL\Mutations\Core;

use App\Exceptions\ModelNotFoundException;
use App\GraphQL\Mutations\UpdateUserMutation;

class Logout extends UpdateUserMutation
{
    protected function handle()
    {
        $user = $this->getModel();
        $token = $user->token();
        if ($token) {
            return $token->revoke();
        }

        throw new ModelNotFoundException('Token not exist', 'Your token is invalid');
    }
}
