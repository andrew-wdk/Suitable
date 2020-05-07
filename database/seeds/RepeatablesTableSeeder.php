<?php

use Illuminate\Database\Seeder;
use App\Repeatable;
use App\User;
use Carbon\Carbon;

class RepeatablesTableSeeder extends Seeder
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

        Foreach($user_ids as $id){
            Repeatable::create([
                'start' => $start = $this->addTime('20:00:00', $this->TimeBetween(0, 5)),
                'end' => $this->addTime($start, $this->TimeBetween(6, 14)),
                'title' => 'sleep',
                'Mon' => 1,
                'Tue' => 1,
                'Wed' => 1,
                'Thu' => 1,
                'Fri' => 1,
                'Sat' => 1,
                'Sun' => 1,
                'user_id' => $id]);

            $count = rand(0, 5);
            $prev = now();

            for($i = 0; $i < $count; $i++){

                $noDay = true;  // to check whether the repeatable has been set to any day of the week

                $one = function (&$noDay) {
                    $noDay = false;
                    return 1;
                };

                $rep = Repeatable::create([
                    'start' =>($start = $faker->time('H:i:s')),
                    'end' => ($prev = $this->addTime($start, $this->TimeBetween(1, 5))),
                    'title' => $faker->word,
                    'Mon' => rand(1, 7) <= 2 ? $one($noDay) : null,
                    'Tue' => rand(1, 7) <= 2 ? $one($noDay) : null,
                    'Wed' => rand(1, 7) <= 2 ? $one($noDay) : null,
                    'Thu' => rand(1, 7) <= 2 ? $one($noDay) : null,
                    'Fri' => rand(1, 7) <= 2 ? $one($noDay) : null,
                    'Sat' => rand(1, 7) <= 2 ? $one($noDay) : null,
                    'Sun' => rand(1, 7) <= 2 ? $one($noDay) : null,
                    'user_id' => $id
                ]);

                // delete the repeatble if all days are null
                if ($noDay){
                    $rep->delete();
                }
            }

        }

    }

    public static function addTime($time1, $time2)
    {
        $secs = strtotime($time2)-strtotime("00:00:00");
        return date("H:i:s",strtotime($time1)+$secs);
    }

    public static function TimeBetween($minHours, $maxHours)
    {
         return date("H:i:s",rand($minHours*3600, $maxHours*3600));
    }

}
