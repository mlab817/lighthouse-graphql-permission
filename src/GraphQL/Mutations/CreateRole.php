<?php

namespace Mlab817\LighthouseGraphQLPermission\GraphQL\Mutations;

use Mlab817\LighthouseGraphQLPermission\Traits\DefaultGuard;
use Spatie\Permission\Models\Role;

class CreateRole
{
    use DefaultGuard;

    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        return Role::create([
            'name' => $args['name'],
            'guard_name' => $this->guard,
        ]);
    }
}
