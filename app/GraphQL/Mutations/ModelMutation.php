<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 23.09.2019
 * Time: 11:40
 */

namespace App\GraphQL\Mutations;

use App\Exceptions\ModelNotFoundException;
use App\GraphQL\Interfaces\Mutation as MutationInterface;
use App\GraphQL\Interfaces\ModelMutation as ModelMutationInterface;
use Illuminate\Database\Eloquent\Model;
use Str;
use Throwable;

abstract class ModelMutation extends Mutation implements ModelMutationInterface
{
    /**
     * Model instance
     * @var Model $model
     */
    protected $model;
    /**
     * Model lookup exception
     * @var ModelNotFoundException $modelNotFoundException
     */
    private $modelNotFoundException;

    /**
     * Override this method to get model for simple update or insert
     * @return Model
     * @throws ModelNotFoundException
     */
    public function getModel()
    {
        if (!$this->model) {
            $this->model = $this->lookupModel();
        }

        return $this->model;
    }

    /**
     * Override this method to get model exception if model not found etc.
     * @return ModelNotFoundException
     */
    public function getModelNotFoundException()
    {
        if (!$this->modelNotFoundException) {
            $modelClass = class_basename($this->getModelClass());
            $verb = preg_match('~^(\w[a-z]+)~', class_basename(static::class), $match) ?
                Str::lower($match[1]) : 'change';
            $verb .= $verb[-1] !== 'e' ? 'ed' : 'd';
            $this->modelNotFoundException = new ModelNotFoundException(
                sprintf('%s has not been %s', $modelClass, $verb),
                sprintf('The specified %s not found', Str::lower($modelClass))
            );
        }
        return $this->modelNotFoundException;
    }

    /**
     * @param Throwable $modelException
     * @return MutationInterface
     */
    public function setModelNotFoundException(Throwable $modelException): MutationInterface
    {
        $this->modelNotFoundException = $modelException;
        return $this;
    }

    /**
     * Sync output attributes to model
     * @return Model
     * @throws ModelNotFoundException
     */
    protected function sync()
    {
        $model = $this->getModel();

        foreach ($this->toArray() as $attribute => $value) {
            $model->$attribute = $value;
        }

        return $model;
    }

    /**
     * @return Model
     * @throws ModelNotFoundException
     */
    protected function save()
    {
        $model = $this->sync();

        if ($model->isDirty()) {
            $model->save();
        }

        return $model;
    }

    /**
     * @return Model
     * @throws ModelNotFoundException
     */
    protected function lookupModel()
    {
        $model = $this->getBuilder()->first();

        if (!$model) {
            throw $this->getModelNotFoundException();
        }

        return $model;
    }
}
