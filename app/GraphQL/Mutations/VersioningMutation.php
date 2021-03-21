<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 24.09.2019
 * Time: 17:38
 */

namespace App\GraphQL\Mutations;

use App\Exceptions\ModelNotFoundException;
use Exception;
use Illuminate\Database\Eloquent\Model;

class VersioningMutation extends ModelMutation
{
    /**
     * @return Model
     * @throws ModelNotFoundException
     * @throws Exception
     */
    protected function save()
    {
        $old = $this->getModel();
        $old->delete();

        $this->model = $this->newModel();
        $this->model->timeline_id = $old->timeline_id;

        return parent::save();
    }
}
