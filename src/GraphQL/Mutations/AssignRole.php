<?php

namespace Mlab817\LighthouseGraphQLPermission\GraphQL\Mutations;

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
        $userModel = $this->getUserClass();

        $user = $userModel::findOrFail($args['user_id']);

        $role = Role::findByName($args['role'], $this->guard);

        $user->assignRole($role);

        return $user;
    }

    public function getUserClass(): string
    {
        return config('auth.providers.users.model');
    }
}
