<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(UnavailablesTableSeeder::class);
        $this->call(RepeatablesTableSeeder::class);
        $this->call(EventsTableSeeder::class);

        DB::table('roles')->insert(
            ['name' => 'admin', 'guard_name' => 'web']
        );

        DB::table('model_has_roles')->insert(
            ['role_id' => 1, 'model_type' => 'App\User', 'model_id' => 1]
        );

    }
}
