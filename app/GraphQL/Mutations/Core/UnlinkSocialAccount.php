<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 05.09.2019
 * Time: 19:21
 */

namespace App\GraphQL\Mutations\Core;

use App\GraphQL\Mutations\DeleteMutation;
use App\Models\Core\SocialAccount;

class UnlinkSocialAccount extends DeleteMutation
{
    protected $modelClass = SocialAccount::class;

    // todo: add checks for possibility
}
