<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy <dmitriy@riabov.info>
 * Date: 04.09.2019
 * Time: 13:43
 */

namespace App\GraphQL\Directives;

use GraphQL\Language\AST\FieldDefinitionNode;
use GraphQL\Language\AST\ObjectTypeDefinitionNode;
use Nuwave\Lighthouse\Exceptions\DefinitionException;
use Nuwave\Lighthouse\Pagination\PaginationManipulator;
use Nuwave\Lighthouse\Schema\AST\DocumentAST;
use Nuwave\Lighthouse\Schema\Directives\HasManyDirective as LighthouseHasManyDirective;

class HasManyDirective extends LighthouseHasManyDirective
{
//    public static function definition(): string
//    {
//        return str_replace('type: String', 'type: String = "paginator"', parent::definition());
//    }

    /**
     * @param DocumentAST $documentAST
     * @param FieldDefinitionNode $fieldDefinition
     * @param ObjectTypeDefinitionNode $parentType
     * @return void
     */
    public function manipulateFieldDefinition(DocumentAST &$documentAST, FieldDefinitionNode &$fieldDefinition, ObjectTypeDefinitionNode &$parentType): void
    {
        $paginationType = $this->paginationType();

        // We default to not changing the field if no pagination type is set explicitly.
        // This makes sense for relations, as there should not be too many entries.
        if (! $paginationType) {
            return;
        }

        PaginationManipulator::transformToPaginatedField(
            $paginationType,
            $fieldDefinition,
            $parentType,
            $documentAST,
            $this->paginateDefaultCount(),
            $this->paginateMaxCount(),
            $this->edgeType($documentAST)
        );
    }

//    /**
//     * @return PaginationType
//     * @throws DefinitionException
//     */
//    protected function paginationType(): PaginationType
//    {
//        return new PaginationType(
//            $this->directiveArgValue('type', PaginationType::TYPE_PAGINATOR)
//        );
//    }

    protected function paginateDefaultCount(): ?int
    {
        return $this->directiveArgValue('defaultCount', config('lighthouse.paginate_default_count'));
    }
}
