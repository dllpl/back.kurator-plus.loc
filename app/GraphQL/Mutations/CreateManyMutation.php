<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 23.09.2019
 * Time: 11:41
 */

namespace App\GraphQL\Mutations;

class CreateManyMutation extends Mutation
{
    /**
     * @return bool
     */
    protected function save()
    {
        return $this->getBuilder()->insert($this->toArray());
    }
}
