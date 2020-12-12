<?php

namespace Mlab817\LighthouseGraphQLPermission\Traits;

trait DefaultGuard
{
    public $guard;

    public function __construct()
    {
        $this->guard = config('lighthouse-graphql-permission.guard');
    }
}
