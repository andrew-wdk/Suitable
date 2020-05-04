<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\DateTimePeriod;
use Carbon\Carbon;

class DateTimePeriodTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    /** @test */
    public function PeriodCompare_function()
    {   $dateTimeString = "2020-01-01 20:00:00";
        $d1 = new DateTimePeriod($dateTimeString, $dateTimeString);
        $d1->endDate->addHours(6);
        $d1_start = $d1->startDate->toImmutable();
        $d1_end = $d1->endDate->toImmutable();
        //dd($d1_start->isImmutable());

        $d2 = new DateTimePeriod($d1_start->subHours(3), $d1_end->subHours(7));
        $relation = DateTimePeriod::PeriodCompare($d2, $d1);
        $this->assertEquals(1, $relation);

        $d2 = new DateTimePeriod($d1_start->subHours(3), $d1_end->subHours(6));
        $relation = DateTimePeriod::PeriodCompare($d2, $d1);
        $this->assertEquals(1, $relation);

        $d2 = new DateTimePeriod($d1_start->subHours(3), $d1_end->subHours(3));
        $relation = DateTimePeriod::PeriodCompare($d2, $d1);
        $this->assertEquals(2, $relation);

        $d2 = new DateTimePeriod($d1_start, $d1_end->subHours(3));
        $relation = DateTimePeriod::PeriodCompare($d2, $d1);
        $this->assertEquals(3, $relation);

        $d2 = new DateTimePeriod($d1_start->addHours(2), $d1_end->subHours(3));
        $relation = DateTimePeriod::PeriodCompare($d2, $d1);
        $this->assertEquals(4, $relation);

        $d2 = new DateTimePeriod($d1_start->addHours(2), $d1_end);
        $relation = DateTimePeriod::PeriodCompare($d2, $d1);
        $this->assertEquals(5, $relation);

        $d2 = new DateTimePeriod($d1_start, $d1_end);
        $relation = DateTimePeriod::PeriodCompare($d2, $d1);
        $this->assertEquals(6, $relation);

        $d2 = new DateTimePeriod($d1_start->subHours(2), $d1_end);
        $relation = DateTimePeriod::PeriodCompare($d2, $d1);
        $this->assertEquals(7, $relation);

        $d2 = new DateTimePeriod($d1_start->subHours(2), $d1_end->addHours(2));
        $relation = DateTimePeriod::PeriodCompare($d2, $d1);
        $this->assertEquals(8, $relation);

        $d2 = new DateTimePeriod($d1_start, $d1_end->addHours(3));
        $relation = DateTimePeriod::PeriodCompare($d2, $d1);
        $this->assertEquals(9, $relation);

        $d2 = new DateTimePeriod($d1_start->addHours(2), $d1_end->addHours(3));
        $relation = DateTimePeriod::PeriodCompare($d2, $d1);
        $this->assertEquals(10, $relation);

        $d2 = new DateTimePeriod($d1_start->addHours(6), $d1_end->addHours(3));
        $relation = DateTimePeriod::PeriodCompare($d2, $d1);
        $this->assertEquals(11, $relation);

        $d2 = new DateTimePeriod($d1_start->addHours(7), $d1_end->addHours(3));
        $relation = DateTimePeriod::PeriodCompare($d2, $d1);
        $this->assertEquals(11, $relation);
    }
}
