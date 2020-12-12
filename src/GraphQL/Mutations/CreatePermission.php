<?php

namespace Mlab817\LighthouseGraphQLLaravelPermission\GraphQL\Mutations;

use Mlab817\LighthouseGraphQLLaravelPermission\Traits\DefaultGuard;
use Spatie\Permission\Models\Permission;

class CreatePermission
{
    use DefaultGuard;

    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        return Permission::create([
            'name' => $args['name'],
            'guard_name' => $this->guard,
        ]);
    }
}
