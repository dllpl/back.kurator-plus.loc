<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 21.09.2019
 * Time: 18:24
 */

namespace App\GraphQL\Mutations\Core;

use App\GraphQL\Mutations\UpdateMutation;
use App\Models\Core\User;

class UpdateUser extends UpdateMutation
{
    use TransformUser;

    protected $modelClass = User::class;

    protected function transformAttributes($data)
    {
        parent::transformAttributes($data);

        $this->transformPassword($data)->transformInn($data);

        return $this;
    }
}
