<?php

namespace Mlab817\LighthouseGraphQLPermission\GraphQL\Directives;

use Closure;
use GraphQL\Language\AST\TypeDefinitionNode;
use GraphQL\Language\AST\TypeExtensionNode;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Auth\AuthenticationException;
use Nuwave\Lighthouse\Exceptions\AuthorizationException;
use Nuwave\Lighthouse\Schema\AST\ASTHelper;
use Nuwave\Lighthouse\Schema\AST\DocumentAST;
use Nuwave\Lighthouse\Schema\Directives\BaseDirective;
use Nuwave\Lighthouse\Schema\Values\FieldValue;
use Nuwave\Lighthouse\Support\Contracts\DefinedDirective;
use Nuwave\Lighthouse\Support\Contracts\FieldMiddleware;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Support\Contracts\TypeExtensionManipulator;

class RestrictDirective extends BaseDirective implements FieldMiddleware, DefinedDirective
{
    public function name(): string
    {
        return 'restrict';
    }

    public static function definition(): string
    {
        return /** GraphQL */ <<<'SDL'
"""
Restrict access of permission mutations based on role defined in config
"""
directive @restrict on FIELD_DEFINITION | OBJECT
SDL;

    }

    public function handleField(FieldValue $fieldValue, Closure $next): FieldValue
    {
        $originalResolver = $fieldValue->getResolver();

        return $next(
            $fieldValue->setResolver(
                function ($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) use ($originalResolver) {
                    // if a role restriction is defined
                    // check if user has role
                    if (config('permission.restrict.role')) {
                        $role = config('permission.restrict.role');
                        $user = $context->user();

                        if (!$user) {
                            throw new AuthenticationException('You must be logged in to continue');
                        }

                        if (!$user->hasRole($role)) {
                            throw new AuthorizationException('Admin role is required');
                        }

                        return $originalResolver($root, $args, $context, $resolveInfo);
                    }

                    return $originalResolver($root, $args, $context, $resolveInfo);
                }
            )
        );

    }

    public function manipulateTypeDefinition(DocumentAST &$documentAST, TypeDefinitionNode &$typeDefinition): void
    {
        ASTHelper::addDirectiveToFields($this->directiveNode, $typeDefinition);
    }

    public function manipulateTypeExtension(DocumentAST &$documentAST, TypeExtensionNode &$typeExtension): void
    {
        ASTHelper::addDirectiveToFields($this->directiveNode, $typeExtension);
    }
}
