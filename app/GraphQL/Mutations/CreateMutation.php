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

class CreateMutation extends ModelMutation
{
    /**
     * Override this method to get model for simple update or insert
     * @return Model
     */
    public function getModel()
    {
        if (!$this->model) {
            $this->model = $this->newModel();
        }

        return $this->model;
    }

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
