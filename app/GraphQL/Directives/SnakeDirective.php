<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 29.08.2019
 * Time: 11:19
 */

namespace App\GraphQL\Directives;

use Nuwave\Lighthouse\Schema\Directives\BaseDirective;
use Nuwave\Lighthouse\Schema\Values\FieldValue;
use Nuwave\Lighthouse\Support\Contracts\FieldResolver;
use Str;

class SnakeDirective extends BaseDirective implements FieldResolver
{
    /**
     * Name of the directive.
     *
     * @return string
     */
    public function name(): string
    {
        return 'snake';
    }

    public static function definition(): string
    {
        return /* @lang GraphQL */ <<<'SDL'
"""
Generate the snake-case attribute name associated with the camel-case field name.
"""
directive @snake on FIELD_DEFINITION | ARGUMENT_DEFINITION | INPUT_FIELD_DEFINITION
SDL;
    }

    /**
     * Resolve the field directive.
     *
     * @param FieldValue $fieldValue
     * @return FieldValue
     */
    public function resolveField(FieldValue $fieldValue): FieldValue
    {
        $attribute = Str::snake($fieldValue->getFieldName());

        return $fieldValue->setResolver(
            function ($rootValue) use ($attribute) {
                return data_get($rootValue, $attribute);
            }
        );
    }
}
