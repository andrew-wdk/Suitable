<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::create(['email' => 'admin@site.com',
        'name' => 'Admin', 'Password' => Hash::make('123456')]);
        factory(App\User::class, 50)->create();

    }
}
