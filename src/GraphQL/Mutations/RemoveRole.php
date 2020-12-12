<?php

namespace Mlab817\LighthouseGraphQLPermission\GraphQL\Mutations;

use App\Models\User;
use Mlab817\LighthouseGraphQLPermission\Traits\DefaultGuard;
use Spatie\Permission\Models\Role;

class RemoveRole
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

        $user->removeRole($role);

        return $user;
    }
}
