<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 23.09.2019
 * Time: 11:41
 */

namespace App\GraphQL\Mutations;

use App\Exceptions\ModelNotFoundException;
use Exception;

class DeleteMutation extends ModelMutation
{
    /**
     * @return bool
     * @throws ModelNotFoundException
     * @throws Exception
     */
    protected function save()
    {
        return parent::save()->delete();
    }
}
