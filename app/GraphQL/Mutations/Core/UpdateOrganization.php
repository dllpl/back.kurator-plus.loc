<?php
/**
 * Created by PhpStorm.
 * User: V.A.I
 * Date: 03.09.2019
 * Time: 18:07
 */

namespace App\GraphQL\Mutations\Core;

use App\GraphQL\Mutations\UpdateMutation;
use App\Models\Core\Organization;

class UpdateOrganization extends UpdateMutation
{
    protected $modelClass = Organization::class;

    protected $map = [
        'type' => 'organization_type_id',
    ];
}
