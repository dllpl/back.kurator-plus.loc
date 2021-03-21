<?php

namespace App\GraphQL\Queries;

use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Database\Eloquent\Model;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class Query
{
    /**
     * @var Model $model
     */
    private $model;

    /**
     * Return a value for the field.
     *
     * Usually contains the result returned from the parent field. In this case, it is always `null`.
     * @param Model|null $rootValue
     * The arguments that were passed into the field.
     * @param mixed[] $args
     * Arbitrary data that is shared between all fields of a single query.
     * @param GraphQLContext $context
     * Information about the query itself, such as the execution state, the field name, path to the field from the root, and more.
     * @param ResolveInfo $resolveInfo
     *
     * @return mixed
     */
    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $this->model = $rootValue;

        return $this->call($args);
    }

    /**
     * @param array $args
     * @return mixed
     */
    public function call(array $args)
    {
        return null;
    }

    /**
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }
}
