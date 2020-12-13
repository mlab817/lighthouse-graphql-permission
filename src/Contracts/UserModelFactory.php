<?php

namespace Mlab817\LighthouseGraphQLPermission\Contracts;

use Illuminate\Database\Eloquent\Model;

interface UserModelFactory
{
    public function getClass(): string;

    public function findOrFail($id): Model;
}
