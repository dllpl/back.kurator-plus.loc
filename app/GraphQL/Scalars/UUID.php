<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 28.08.2019
 * Time: 14:56
 */

namespace App\GraphQL\Scalars;

use GraphQL\Type\Definition\ScalarType;
use Illuminate\Validation\ValidationException;
use Validator;

/**
 * Read more about scalars here http://webonyx.github.io/graphql-php/type-system/scalar-types/
 */
class UUID extends ScalarType
{
    /**
     * Serializes an internal value to include in a response.
     *
     * @param  mixed  $value
     * @return mixed
     */
    public function serialize($value)
    {
        // Assuming the internal representation of the value is always correct
        return $value;

        // TODO validate if it might be incorrect
    }

    /**
     * Parses an externally provided value (query variable) to use as an input
     *
     * @param mixed $value
     * @return mixed
     * @throws ValidationException
     */
    public function parseValue($value)
    {
        $this->validate($value);

        return $value;
    }

    /**
     * Parses an externally provided literal value (hardcoded in GraphQL query) to use as an input.
     *
     * E.g.
     * {
     *   user(email: "user@example.com")
     * }
     *
     * @param  \GraphQL\Language\AST\Node  $valueNode
     * @param  mixed[]|null  $variables
     * @return mixed
     */
    public function parseLiteral($valueNode, ?array $variables = null)
    {
        // TODO implement validation

        return $valueNode->value;
    }

    /**
     * @param $value
     * @return void
     * @throws ValidationException
     */
    protected function validate($value): void
    {
        Validator::validate(['value' => $value], ['value' => 'uuid']);
    }
}
