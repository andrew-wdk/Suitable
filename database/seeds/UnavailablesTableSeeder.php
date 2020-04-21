<?php

use Illuminate\Database\Seeder;
use App\Unavailable;
use App\User;
use Carbon\Carbon;

class UnavailablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_ids = User::pluck('id')->toArray();
        $faker = Faker\Factory::create();
        $prev = now();
        Foreach($user_ids as $id){
            $count = rand(0, 4);
            for($i = 0; $i < $count; $i++){
                Unavailable::create([
                'start' =>($start = $faker->dateTimeInInterval($prev, '+2 days')),
                'end' => ($prev = $faker->dateTimeInInterval($start, '+5 hours')),
                'title' => $faker->word,
                'user_id' => $id
            ]);}

        }
    }
}
