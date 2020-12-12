<?php

namespace Mlab817\LighthouseGraphQLLaravelPermission\GraphQL\Mutations;

use App\Models\User;
use Mlab817\LighthouseGraphQLLaravelPermission\Traits\DefaultGuard;

class RevokePermissionToUser
{
    use DefaultGuard;

    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $user = User::find($args['user_id']);
        $user->revokePermissionTo($args['permission'], $this->guard);

        return $user;
    }
}
