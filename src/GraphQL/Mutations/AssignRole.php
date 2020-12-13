<?php

namespace Mlab817\LighthouseGraphQLPermission\GraphQL\Mutations;

use App\User;
use Mlab817\LighthouseGraphQLPermission\Traits\DefaultGuard;
use Spatie\Permission\Models\Role;

class AssignRole
{
    use DefaultGuard;

    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return mixed
     */
    public function __invoke($_, array $args)
    {
        $user = User::findOrFail($args['user_id']);

        $role = Role::findByName($args['role'], $this->guard);

        $user->assignRole($role);

        return $user;
    }
}
