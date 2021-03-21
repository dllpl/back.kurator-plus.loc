<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 30.08.2019
 * Time: 01:50
 */

namespace App\GraphQL\Directives;

use GraphQL\Language\AST\FieldDefinitionNode;
use GraphQL\Language\AST\ObjectTypeDefinitionNode;
use Nuwave\Lighthouse\Pagination\PaginationManipulator;
use Nuwave\Lighthouse\Schema\AST\DocumentAST;
use Nuwave\Lighthouse\Schema\Directives\PaginateDirective as LighthousePaginateDirective;

class PaginateDirective extends LighthousePaginateDirective
{
    /**
     * @param DocumentAST $documentAST
     * @param FieldDefinitionNode $fieldDefinition
     * @param ObjectTypeDefinitionNode $parentType
     * @return void
     */
    public function manipulateFieldDefinition(DocumentAST &$documentAST, FieldDefinitionNode &$fieldDefinition, ObjectTypeDefinitionNode &$parentType): void
    {
        PaginationManipulator::transformToPaginatedField(
            $this->paginationType(),
            $fieldDefinition,
            $parentType,
            $documentAST,
            $this->paginateDefaultCount(),
            $this->paginateMaxCount()
        );
    }

    protected function paginateDefaultCount(): ?int
    {
        return $this->directiveArgValue('defaultCount', config('lighthouse.paginate_default_count'));
    }
}
