<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 27.10.2019
 * Time: 14:38
 */

namespace App\GraphQL\Mutations\Core;

use App\GraphQL\Mutations\DeleteRelationMutation;
use App\Models\Core\StreamLeader;

class UnlinkLeaderFromStream extends DeleteRelationMutation
{
    protected $modelClass = StreamLeader::class;
}
