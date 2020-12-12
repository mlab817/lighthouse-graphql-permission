<?php

namespace Mlab817\LighthouseGraphQLLaravelPermission\Providers;

use GraphQL\Utils\BuildSchema;
use Illuminate\Support\ServiceProvider;
use Nuwave\Lighthouse\Events\BuildSchemaString;

class LighthouseGraphQLPermissionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig();

        app('events')->listen(
            BuildSchemaString::class,
            function (): string {
                if (config('lighthouse-graphql-laravel-permission.schema')) {
                    return file_get_contents(config('lighthouse-graphql-laravel-permission.schema'));
                }

                return file_get_contents(__DIR__.'/../../graphql/permission.graphql');
            }
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/config.php',
            'lighthouse-graphql-laravel-permission'
        );

        $this->publishes([
            __DIR__.'/../../config/config.php' => config_path('lighthouse-graphql-laravel-permission.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../../graphql/permission.graphql' => base_path('graphql/permission.graphql'),
        ], 'lighthouse-graphql-laravel-permission-schema');

    }
}
