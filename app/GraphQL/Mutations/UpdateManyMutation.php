<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 23.09.2019
 * Time: 11:42
 */

namespace App\GraphQL\Mutations;

class UpdateManyMutation extends Mutation
{
    /**
     * @return int
     */
    protected function save()
    {
        return $this->getBuilder()->update($this->toArray());
    }
}
