<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 25.09.2019
 * Time: 14:33
 */

namespace App\GraphQL\Directives;

use GraphQL\Language\AST\FieldDefinitionNode;
use GraphQL\Language\AST\ObjectTypeDefinitionNode;
use Nuwave\Lighthouse\Schema\AST\ASTHelper;
use Nuwave\Lighthouse\Schema\AST\DocumentAST;
use Nuwave\Lighthouse\Schema\AST\PartialParser;
use Nuwave\Lighthouse\SoftDeletes\SoftDeletesDirective as LighthouseSoftDeletesDirective;

class SoftDeletesDirective extends LighthouseSoftDeletesDirective
{

    public static function definition(): string
    {
        return /* @lang GraphQL */ <<<'SDL'
"""
Allows to filter if trashed elements should be fetched.
This manipulates the schema by adding the argument
`trashed: Trashed = "WITH" @trashed` to the field.
"""
directive @softDeletes(
    default: String = "WITH"
) on FIELD_DEFINITION
SDL;
    }

    /**
     * @param DocumentAST $documentAST
     * @param FieldDefinitionNode $fieldDefinition
     * @param ObjectTypeDefinitionNode $parentType
     * @return void
     */
    public function manipulateFieldDefinition(DocumentAST &$documentAST, FieldDefinitionNode &$fieldDefinition, ObjectTypeDefinitionNode &$parentType): void
    {
        $default = $this->directiveArgValue('default', 'WITH');

        $softDeletesArgument = PartialParser::inputValueDefinition(/* @lang GraphQL */ <<<SDL
"""
Allows to filter if trashed elements should be fetched.
"""
trashed: Trashed = "$default" @trashed
SDL
        );
        $fieldDefinition->arguments = ASTHelper::mergeNodeList($fieldDefinition->arguments, [$softDeletesArgument]);
    }
}
