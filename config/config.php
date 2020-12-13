<?php

return [
    /*
     * Define where the schema will be stored
     */
    'schema' => null,
    /*
     * Determine the guard to use as default guard_name when creating roles and permissions
     * Defaults to api
     */
    'guard' => env('PERMISSION_GUARD', 'api'),
    /*
     * Restrict mutations to specific role
     */
    'restrict' => [
        'role' => env('PERMISSION_RESTRICT_MUTATIONS','admin')
    ],

    'users' => [
        'table' => 'users'
    ],
];
