<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 23.09.2019
 * Time: 11:41
 */

namespace App\GraphQL\Mutations;

use App\Exceptions\ModelNotFoundException;
use Illuminate\Database\Eloquent\Model;

class UpdateMutation extends ModelMutation
{
    /**
     * @return Model
     * @throws ModelNotFoundException
     */
    protected function save()
    {
        $model = parent::save();
        // todo: remove after implemented a numerator
        $model->refresh();

        return $model;
    }
}
