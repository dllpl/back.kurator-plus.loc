<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 23.09.2019
 * Time: 12:21
 */

namespace App\GraphQL\Interfaces;

use App\Exceptions\ModelNotFoundException;
use Illuminate\Database\Eloquent\Model;
use Throwable;

interface ModelMutation extends Mutation
{
    /**
     * Override this method to get model for simple update or insert
     * @return Model
     * @throws ModelNotFoundException
     */
    public function getModel();

    /**
     * Override this method to get model exception if model not found etc.
     * @return ModelNotFoundException
     */
    public function getModelNotFoundException();

    /**
     * @param Throwable $modelException
     * @return Mutation
     */
    public function setModelNotFoundException(Throwable $modelException): Mutation;
}
