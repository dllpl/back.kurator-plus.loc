<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 21.09.2019
 * Time: 18:32
 */

namespace App\GraphQL\Mutations\Core;

use App\GraphQL\Mutations\DeleteRelationMutation;
use App\Models\Core\RelatedUser;

class UnlinkUserFromOrganization extends DeleteRelationMutation
{
    protected $modelClass = RelatedUser::class;
}
