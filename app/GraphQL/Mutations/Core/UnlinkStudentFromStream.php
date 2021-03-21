<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 27.10.2019
 * Time: 14:01
 */

namespace App\GraphQL\Mutations\Core;

use App\GraphQL\Mutations\DeleteRelationMutation;
use App\Models\Core\StreamStudent;

class UnlinkStudentFromStream extends DeleteRelationMutation
{
    protected $modelClass = StreamStudent::class;
}
