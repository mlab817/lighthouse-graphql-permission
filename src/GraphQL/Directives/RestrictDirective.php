<?php

namespace Mlab817\LighthouseGraphQLPermission\GraphQL\Directives;

use Closure;
use GraphQL\Language\AST\TypeExtensionNode;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Auth\AuthenticationException;
use Nuwave\Lighthouse\Exceptions\AuthorizationException;
use Nuwave\Lighthouse\Schema\AST\ASTHelper;
use Nuwave\Lighthouse\Schema\AST\DocumentAST;
use Nuwave\Lighthouse\Schema\Directives\BaseDirective;
use Nuwave\Lighthouse\Schema\Values\FieldValue;
use Nuwave\Lighthouse\Support\Contracts\FieldMiddleware;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Support\Contracts\TypeExtensionManipulator;

class RestrictDirective extends BaseDirective implements FieldMiddleware, TypeExtensionManipulator
{
    public function name(): string
    {
        return 'restrict';
    }

    public static function definition(): string
    {
        return /** GraphQL */ <<<'SDL'
directive @restrict on FIELD_DEFINITION | OBJECT
SDL;
    }

    public function handleField(FieldValue $fieldValue, Closure $next): FieldValue
    {
        $resolver = $fieldValue->getResolver();

        $fieldValue->setResolver(
            function ($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo
            ) use ($fieldValue, $next, $resolver) {
            // if a role restriction is defined
            // check if user has role
            if (config('permission.restrict.role')) {
                $role = config('permission.restrict.role');
                $user = $context->user();

                if (! $user) {
                    throw new AuthenticationException('You must be logged in to continue');
                }

                if (! $user->hasRole('admin')) {
                    throw new AuthorizationException('Admin role is required');
                }

                return $resolver($root, $args, $context, $resolveInfo);
            }

            return $next($fieldValue);
        });

    }

    public function manipulateTypeExtension(DocumentAST &$documentAST, TypeExtensionNode &$typeExtension)
    {
        ASTHelper::addDirectiveToFields(
            $this->directiveNode,
            $typeExtension
        );
    }
}