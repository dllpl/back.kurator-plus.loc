<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 21.09.2019
 * Time: 18:32
 */

namespace App\GraphQL\Mutations\Core;

use App\GraphQL\Mutations\CreateRelationMutation;
use App\Models\Core\RelatedOrganization;

class LinkUserToOrganization extends CreateRelationMutation
{
    protected $modelClass = RelatedOrganization::class;
}
