<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 30.08.2019
 * Time: 03:38
 */

namespace App\GraphQL\Mutations\Core;

use App\GraphQL\Mutations\UpdateUserMutation;

class UpdateProfile extends UpdateUserMutation
{
    use TransformUser;

    protected function transformAttributes($data)
    {
        parent::transformAttributes($data);

        $this->transformInn($data);

        return $this;
    }
}
