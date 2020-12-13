<?php

namespace Mlab817\LighthouseGraphQLPermission\Factories;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class User extends Model
{
    use HasRoles;

    protected $guard_name = 'api';
}
