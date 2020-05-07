<?php

namespace App;

use Carbon\Carbon;

Class DateTimePeriod
{
    public $startDate;
    public $endDate;
    public $user_id;
    public $length;

    public function __Construct($start, $end, $user_id=null)
    {
        $this->startDate = Carbon::parse($start);
        $this->endDate = Carbon::parse($end);
        $this->user_id = $user_id;
        $this->length = $this->startDate->floatDiffInHours($this->endDate);
    }

    public function setEndDate($end)
    {
        $this->endDate = carbon::parse($end);
        $this->length = $this->startDate->floatDiffInHours($this->endDate);
    }


    public static function periodCompare ($p1, $p2)
    {
        if ($p1->startDate->lt($p2->startDate))
        {
            if ($p1->endDate->lte($p2->startDate))
            {
                return 1;
            }
            if ($p1->endDate->lt($p2->endDate))
            {
                return 2;
            }
            if ($p1->endDate->eq($p2->endDate))
            {
                return 7;
            }
            if ($p1->endDate->gt($p2->endDate))
            {
                return 8;
            }
        }
        if ($p1->startDate->eq($p2->startDate))
        {
            if ($p1->endDate->lt($p2->endDate))
            {
                return 3;
            }
            if ($p1->endDate->eq($p2->endDate))
            {
                return 6;
            }
            if ($p1->endDate->gt($p2->endDate))
            {
                return 9;
            }
        }
        if ($p1->startDate->gt($p2->startDate))
        {
            if ($p1->startDate->gte($p2->endDate))
            {
                return 11;
            }
            if ($p1->endDate->lt($p2->endDate))
            {
                return 4;
            }
            if ($p1->endDate->eq($p2->endDate))
            {
                return 5;
            }
            if ($p1->endDate->gt($p2->endDate))
            {
                return 10;
            }
        }
    }
}
