<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 27.10.2019
 * Time: 14:31
 */

namespace App\GraphQL\Mutations;

class CreateRelationMutation extends CreateMutation
{
    protected $map = [
        'relationship' => 'relationship_id', // optional
        'date' => 'started_at',
    ];

    protected function transformAttributes($data)
    {
        parent::transformAttributes($data);

        if (!isset($data->started_at)) {
            $data->started_at = now()->startOfDay();
        }

        return $this;
    }
}
