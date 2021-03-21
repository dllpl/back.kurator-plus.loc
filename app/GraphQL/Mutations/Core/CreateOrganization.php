<?php
/**
 * Created by PhpStorm.
 * User: V.A.I
 * Date: 04.09.2019
 * Time: 19:41
 */

namespace App\GraphQL\Mutations\Core;

use App\GraphQL\Mutations\CreateMutation;
use App\Models\Core\Organization;
use App\Models\Core\Relationship;
use Throwable;

class CreateOrganization extends CreateMutation
{
    protected $modelClass = Organization::class;

    protected $map = [
        'type' => 'organization_type_id',
    ];
}
