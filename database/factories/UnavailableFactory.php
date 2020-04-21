<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Unavailable;
use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(Unavailable::class, function (Faker $faker) {
    return [
        'start' => $start = $faker->dateTimeBetween($startDate = $prev, $endDate = '+2 days', $timezone = null),
        'end' => $faker->dateTimeInInterval($startDate = $start, $interval = '+ 5 hours', $timezone = null),
        'title' => $faker->word
    ];
});
