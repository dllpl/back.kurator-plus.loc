<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 27.10.2019
 * Time: 14:29
 */

namespace App\GraphQL\Mutations\Core;

use App\GraphQL\Mutations\CreateRelationMutation;
use App\Models\Core\Relationship;
use App\Models\Core\StreamLeader;

class LinkLeaderToStream extends CreateRelationMutation
{
    protected $modelClass = StreamLeader::class;

    protected function transformAttributes($data)
    {
        parent::transformAttributes($data);

        $data->relationship_id = Relationship::STREAM_LEADER;

        return $this;
    }
}
