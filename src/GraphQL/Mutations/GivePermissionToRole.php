<?php

namespace Mlab817\LighthouseGraphQLPermission\GraphQL\Mutations;

use Mlab817\LighthouseGraphQLPermission\Traits\DefaultGuard;
use Spatie\Permission\Models\Role;

class GivePermissionToRole
{
    use DefaultGuard;

    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $role = Role::findByName($args['role']);
        $role->givePermissionTo($args['permission'], $this->guard);

        return $role;
    }
}
