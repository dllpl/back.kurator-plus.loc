<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 27.10.2019
 * Time: 14:37
 */

namespace App\GraphQL\Mutations;

class DeleteRelationMutation extends DeleteMutation
{
    protected $map = [
        'date' => 'ended_at',
    ];

    protected function transformAttributes($data)
    {
        parent::transformAttributes($data);

        if (!isset($data->ended_at)) {
            $data->ended_at = now()->startOfDay();
        }

        return $this;
    }
}
