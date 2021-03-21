<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 03.09.2019
 * Time: 19:31
 */

namespace App\GraphQL\Mutations;

use App\Exceptions\GraphqlException;
use App\Exceptions\ModelNotFoundException;
use App\Exceptions\ModelSaveException;
use App\GraphQL\Interfaces\Mutation as MutationInterface;
use Arr;
use ArrayAccess;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Str;
use Throwable;
use Validator;

abstract class Mutation implements MutationInterface, ArrayAccess, Arrayable
{
    /**
     * Name of input argument
     * @var string $inputArgument
     */
    protected $inputArgument = 'input';
    /**
     * Mapping input fields to output attributes
     * @var array $map
     */
    protected $map = [];
    /**
     * Input fields that should be excluded
     * @var array $excluded
     */
    protected $excluded = [];
    /**
     * Validation rules for input fields
     * @var array $rules
     */
    protected $rules = [];
    /**
     * Model class
     * @var string $modelClass
     */
    protected $modelClass;
    /**
     * Use transaction in mutation
     * By default, this value is taken from config('lighthouse.transactional_mutations')
     * @var bool $transactional
     */
    protected $transactional;
    /**
     * Values of all arguments except input
     * @var array $vars
     */
    private $vars;
    /**
     * Mutation data
     * @var MutationData|MutationData[] $data
     */
    private $data;
    /**
     * Builder instance
     * @var Builder $builder
     */
    private $builder;
    /**
     * Model save exception
     * @var ModelSaveException $modelSaveException
     */
    private $modelSaveException;

    public function __construct()
    {
        $this->transactional = config('lighthouse.transactional_mutations', true);
    }

    /**
     * Static version of call method
     * @param array $input
     * @param array $vars
     * @return mixed
     * @throws ModelNotFoundException
     * @throws ModelSaveException
     * @throws ValidationException
     * @throws Throwable
     */
    public static function mutate(array $input = [], array $vars = [])
    {
        /** @var self $mutation */
        $mutation = app(static::class);
        return $mutation->call($input, $vars);
    }

    /**
     * @param array $input
     * @param array $vars
     * @return mixed
     * @throws ModelNotFoundException
     * @throws ModelSaveException
     * @throws ValidationException
     * @throws Throwable
     */
    public function call(array $input = [], array $vars = [])
    {
        $this->data = MutationData::build($input);
        $this->vars = $vars;

        return $this->transactional ? $this->getBuilder()->getConnection()->transaction(function () {
            return $this->handle();
        }) : $this->handle();
    }

    /**
     * Override this method to implement custom business logic
     * @return Model|bool
     * @throws ModelNotFoundException
     * @throws ModelSaveException
     * @throws ValidationException
     */
    protected function handle()
    {
        try {
            if ($this->data instanceof MutationData) {
                $this->checkInput($this->data)->transformAttributes($this->data);
            }
            else {
                foreach ($this->data as $item) {
                    $this->checkInput($item)->transformAttributes($item);
                }
            }

            return $this->save();
        }
        catch (QueryException $exception) {
            throw $this->transformQueryException($exception);
        }
    }

    /**
     * Override this method to check input fields
     * @param MutationData $data
     * @return self
     * @throws ValidationException
     */
    protected function checkInput($data)
    {
        Validator::validate($data->getInput(), $this->rules);
        return $this;
    }

    /**
     * Override this method to transform input fields to Model attributes.
     * You need to call parent method to process a default mapping.
     * @param MutationData $data
     * @return self
     */
    protected function transformAttributes($data)
    {
        foreach (Arr::except($data->getInput(), $this->excluded) as $key => $value) {
            $attribute = Str::snake($this->map[$key] ?? $key);
            $data->$attribute = $value;
        }
        return $this;
    }

    abstract protected function save();

    /**
     * Return a value for the field.
     *
     * Usually contains the result returned from the parent field. In this case, it is always `null`.
     * @param null $rootValue
     * The arguments that were passed into the field.
     * @param mixed[] $args
     * Arbitrary data that is shared between all fields of a single query.
     * @param GraphQLContext $context
     * Information about the query itself, such as the execution state, the field name, path to the field from the root, and more.
     * @param ResolveInfo $resolveInfo
     *
     * @return mixed
     * @throws ModelNotFoundException
     * @throws ModelSaveException
     * @throws ValidationException
     * @throws Throwable
     */
    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        return $this->call($args[$this->inputArgument] ?? [], Arr::except($args, [$this->inputArgument]));
    }

    /**
     * @return array
     */
    public function getExcluded(): array
    {
        return $this->excluded;
    }

    /**
     * @param array $excluded
     * @return self
     */
    public function setExcluded(array $excluded): MutationInterface
    {
        $this->excluded = $excluded;
        return $this;
    }

    /**
     * @return array
     */
    public function getMap(): array
    {
        return $this->map;
    }

    /**
     * @param array $map
     * @return self
     */
    public function setMap(array $map): MutationInterface
    {
        $this->map = $map;
        return $this;
    }

    /**
     * @return string
     */
    public function getModelClass(): string
    {
        return $this->modelClass;
    }

    /**
     * @param string $modelClass
     * @return self
     */
    public function setModelClass(string $modelClass): MutationInterface
    {
        $this->modelClass = $modelClass;
        return $this;
    }

    /**
     * @return string
     */
    public function getInputArgument(): string
    {
        return $this->inputArgument;
    }

    /**
     * @param string $inputArgument
     * @return self
     */
    public function setInputArgument(string $inputArgument): MutationInterface
    {
        $this->inputArgument = $inputArgument;
        return $this;
    }

    /**
     * Override this method to get model exception if integrity constraint violation occurs while saving the model.
     * @return ModelSaveException
     */
    public function getModelSaveException()
    {
        return $this->modelSaveException;
    }

    /**
     * @param ModelSaveException $modelSaveException
     * @return self
     */
    public function setModelSaveException(ModelSaveException $modelSaveException): MutationInterface
    {
        $this->modelSaveException = $modelSaveException;
        return $this;
    }

    /**
     * @return bool
     */
    public function isTransactional(): bool
    {
        return $this->transactional;
    }

    /**
     * @param bool $transactional
     * @return self
     */
    public function setTransactional(bool $transactional): MutationInterface
    {
        $this->transactional = $transactional;
        return $this;
    }

    /**
     * @return array
     */
    public function getRules(): array
    {
        return $this->rules;
    }

    /**
     * @param array $rules
     * @return self
     */
    public function setRules(array $rules): MutationInterface
    {
        $this->rules = $rules;
        return $this;
    }

    /**
     * Whether a offset exists
     * @link https://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     * @throws GraphqlException
     */
    public function offsetExists($offset)
    {
        $this->checkForData(true);

        return isset($this->data[$offset]);
    }

    /**
     * @param bool $failWhen
     * @throws GraphqlException
     */
    private function checkForData(bool $failWhen): void
    {
        if ($this->data instanceof MutationData === $failWhen) {
            throw new GraphqlException(sprintf(
                'Invalid reference for %s-mutation',
                $failWhen ? 'model' : 'many'
            ));
        }
    }

    /**
     * Offset to retrieve
     * @link https://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return MutationData
     * @since 5.0.0
     * @throws GraphqlException
     */
    public function offsetGet($offset)
    {
        $this->checkForData(true);

        return $this->data[$offset];
    }

    /**
     * Offset to set
     * @link https://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     * @since 5.0.0
     * @throws GraphqlException
     */
    public function offsetSet($offset, $value)
    {
        $this->checkForData(true);

        $this->data[$offset] = $value;
    }

    /**
     * Offset to unset
     * @link https://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     * @since 5.0.0
     * @throws GraphqlException
     */
    public function offsetUnset($offset)
    {
        $this->checkForData(true);

        unset($this->data[$offset]);
    }

    /**
     * @param string $name
     * @return mixed
     * @throws GraphqlException
     */
    public function __get(string $name)
    {
        if (!isset($this->vars[$name])) { // temporary workaround for delete many
            $this->checkForData(false);
        }

        return $this->vars[$name] ?? $this->data->__get($name);
    }

    /**
     * @param string $name
     * @param mixed $value
     * @throws GraphqlException
     */
    public function __set(string $name, $value)
    {
        $this->checkForData(false);

        $this->data->__set($name, $value);
    }

    /**
     * @param string $name
     * @return bool
     * @throws GraphqlException
     */
    public function __isset(string $name)
    {
        $this->checkForData(false);

        return $this->data->__isset($name);
    }

    /**
     * @param string $name
     * @throws GraphqlException
     */
    public function __unset($name)
    {
        $this->checkForData(false);

        $this->data->__unset($name);
    }

    /**
     * Get the mutation data as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        if ($this->data instanceof MutationData) {
            return $this->data->getAttributes();
        }

        $result = [];
        foreach ($this->data as $item) {
            $result[] = $item->getAttributes();
        }

        return $result;
    }

    /**
     * @return Builder
     */
    protected function getBuilder(): Builder
    {
        if (!$this->builder) {
            $this->builder = $this->newModel()->newQuery();
            foreach (Arr::except($this->vars, $this->excluded) as $key => $value) {
                $column = Str::snake($this->map[$key] ?? $key);
                if (is_array($value)) {
                    $this->builder->whereIn($column, $value);
                }
                else {
                    $this->builder->where($column, $value);
                }
            }
        }
        return $this->builder;
    }

    protected function newBuilder(): Builder
    {
        return $this->newModel()->newQuery();
    }

    /**
     * @return Model
     */
    protected function newModel()
    {
        return app($this->modelClass);
    }

    /**
     * @param QueryException $exception
     * @return ModelNotFoundException|ModelSaveException|QueryException
     */
    private function transformQueryException(QueryException $exception)
    {
        switch ($exception->getCode()) {
            case '23000':
                $message = 'Integrity constraint violation';
                break;
            case '23001':
                $message = 'Restrict violation';
                break;
            case '23502': // Not null violation
                $message = preg_match(
                        '~ERROR:.*?"(\w+)"~',
                        $exception->getPrevious()->getMessage(),
                        $match
                    ) ?
                    sprintf('%s should be not null', Str::camel($match[1])) :
                    'Not null violation: one of fields is empty';
                break;
            case '23503': // Foreign key violation
                $message = preg_match(
                        '~DETAIL:.*?\((\w+)\)=\(([\w-]*)\)~',
                        $exception->getPrevious()->getMessage(),
                        $match
                    ) ?
                    sprintf('The specified %s not found', Str::camel($match[1])) :
                    'One of the specified input objects not found';

                // todo: need to think about how to determine the related model
                return new ModelNotFoundException($message);
            case '23505':
                $message = 'Unique violation';
                break;
            case '23514':
                $message = 'Check violation';
                break;
            case '23P01':
                $message = 'Exclusion violation';
                break;
            default:
                return $exception;
        }
        return new ModelSaveException($message);
    }
}
