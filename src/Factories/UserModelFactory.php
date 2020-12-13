<?php

namespace Mlab817\LighthouseGraphQLPermission\Factories;

use Illuminate\Config\Repository;
use Illuminate\Database\Eloquent\Model;
use \Mlab817\LighthouseGraphQLPermission\Contracts\UserModelFactory as UserModelContract;

class UserModelFactory implements UserModelContract
{
    private $config;

    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    public function getClass(): string
    {
        return $this->config->get('auth.providers.users.model');
    }

    public function findOrFail($id): Model
    {
        return $this->findOrFail($id);
    }
}
