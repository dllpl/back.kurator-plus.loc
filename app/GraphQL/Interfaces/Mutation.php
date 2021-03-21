<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 09.09.2019
 * Time: 1:18
 */

namespace App\GraphQL\Interfaces;

use App\Exceptions\ModelNotFoundException;
use App\Exceptions\ModelSaveException;
use Illuminate\Validation\ValidationException;
use Throwable;

interface Mutation
{
    /**
     * @param array $input
     * @param array $vars
     * @return mixed
     * @throws ModelNotFoundException
     * @throws ModelSaveException
     * @throws ValidationException
     * @throws Throwable
     */
    public function call(array $input = [], array $vars = []);

    /**
     * @return array
     */
    public function getExcluded(): array;

    /**
     * @param array $excluded
     * @return Mutation
     */
    public function setExcluded(array $excluded): Mutation;

    /**
     * @return array
     */
    public function getMap(): array;

    /**
     * @param array $map
     * @return Mutation
     */
    public function setMap(array $map): Mutation;

    /**
     * @return string
     */
    public function getModelClass(): string;

    /**
     * @param string $modelClass
     * @return Mutation
     */
    public function setModelClass(string $modelClass): Mutation;

    /**
     * @return string
     */
    public function getInputArgument(): string;

    /**
     * @param string $inputArgument
     * @return Mutation
     */
    public function setInputArgument(string $inputArgument): Mutation;

    /**
     * Override this method to get model exception if integrity constraint violation occurs while saving the model.
     * @return ModelSaveException
     */
    public function getModelSaveException();

    /**
     * @param ModelSaveException $modelSaveException
     * @return Mutation
     */
    public function setModelSaveException(ModelSaveException $modelSaveException): Mutation;

    /**
     * @return bool
     */
    public function isTransactional(): bool;

    /**
     * @param bool $transactional
     * @return Mutation
     */
    public function setTransactional(bool $transactional): Mutation;

    /**
     * @return array
     */
    public function getRules(): array;

    /**
     * @param array $rules
     * @return Mutation
     */
    public function setRules(array $rules): Mutation;
}
