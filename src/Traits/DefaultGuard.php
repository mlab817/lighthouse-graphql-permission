<?php

namespace Mlab817\LighthouseGraphQLLaravelPermission\Traits;

trait DefaultGuard
{
    public $guard;

    public function __construct()
    {
        $this->guard = config('lighthouse-graphql-laravel-permission.guard');
    }
}
