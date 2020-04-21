<?php

use Illuminate\Database\Seeder;
use App\Event;
use App\User;

class EventsTableSeeder extends Seeder
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

        foreach($user_ids as $id) {
            if (rand(1, 10) > 2) continue; //only about 20% of users will be event hosts

            $event = Event::create([
                'host_id' => $id,
                'title' => $faker->word,
                'description' => $faker->realText(15),
                'duration' => round($this->nrand(4,1)), // rand no that is normally distributed aroud 4 hours
                'startDate' => $start = $faker->dateTimeInInterval('now','+24 hours'),
                'endDate' => $faker->dateTimeInInterval($start,'+10 days'),
                'participants' => 1
            ]);
            //add participants
            $values = [];

            $validUser = function($n) use($user_ids, $id) {
                // validates random numbers generated for a participant id
                $range = $n > 0 && $n <= sizeof($user_ids);
                $not_host = $n != $id;
                return $range && $id;
            };
            $no_of_participants = rand(1,15);
            for ($i = 0; $i < $no_of_participants; $i++) {
                do{$rand = $faker->valid($validUser)->randomNumber(2);}
                while(in_array($rand, $values)); // checks for repetitions
                $values[$i] = $rand;
                $event->users()->attach($rand);
            }
        }
    }

    // generates normally distributed random numbers
    public function nrand($mean, $sd){
        $x = mt_rand()/mt_getrandmax();
        $y = mt_rand()/mt_getrandmax();
        return sqrt(-2*log($x))*cos(2*pi()*$y)*$sd + $mean;
    }

}
