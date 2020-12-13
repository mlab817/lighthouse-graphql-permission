<?php

namespace Mlab817\LighthouseGraphQLPermission\GraphQL\Directives;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Log;
use Nuwave\Lighthouse\Exceptions\AuthorizationException;
use Nuwave\Lighthouse\Schema\Directives\BaseDirective;
use Nuwave\Lighthouse\Schema\Values\FieldValue;
use Nuwave\Lighthouse\Support\Contracts\DefinedDirective;
use Nuwave\Lighthouse\Support\Contracts\FieldMiddleware;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

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
directive @restrict on FIELD_DEFINITION
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
                    Log::debug('set resolver is running');

                    if (config('lighthouse-graphql-permission.restrict.role')) {
                        Log::debug('role is required');

                        $role = config('lighthouse-graphql-permission.restrict.role');

                        $user = $context->user();

                        if (! $user) {
                            throw new AuthenticationException('You must be logged in to continue');
                        }

                        if (! $user->hasRole($role)) {
                            throw new AuthorizationException('Admin role is required');
                        }
                    }

                    Log::debug('role is not required');

                    return $originalResolver($root, $args, $context, $resolveInfo);
                }
            )
        );

    }

}
