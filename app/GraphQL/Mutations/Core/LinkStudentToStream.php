<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 27.10.2019
 * Time: 14:27
 */

namespace App\GraphQL\Mutations\Core;

use App\GraphQL\Mutations\CreateRelationMutation;
use App\Models\Core\Relationship;
use App\Models\Core\StreamStudent;

class LinkStudentToStream extends CreateRelationMutation
{
    protected $modelClass = StreamStudent::class;

    protected function transformAttributes($data)
    {
        parent::transformAttributes($data);

        $data->relationship_id = Relationship::STUDENT;

        return $this;
    }
}
