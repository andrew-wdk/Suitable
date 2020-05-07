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
                'start' =>($start = $this->addTime($prev, $this->TimeBetween(5, 48))),
                'end' => ($prev = $this->addTime($start, $this->TimeBetween(1, 5))),
                'title' => $faker->word,
                'user_id' => $id
            ]);}
        }

    }
    public static function addTime($time1, $time2)
    {
        $secs = strtotime($time2)-strtotime("00:00:00");
        return date("Y-m-d H:i:s",strtotime($time1)+$secs);
    }

    public static function TimeBetween($minHours, $maxHours)
    {
         return date("H:i:s",rand($minHours*3600, $maxHours*3600));
    }
}
