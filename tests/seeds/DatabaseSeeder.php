<?php

namespace Mlab817\LighthouseGraphQlPermission\tests;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \User::factory(10)->create();
    }
}
