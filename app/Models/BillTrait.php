<?php

namespace CodeFin\Models;

use Carbon\Carbon;

trait BillTrait
{
    public function addDate($dateParam, $numMonthOrYear, $repeatType)
    {
        $date = new Carbon($dateParam);
        $startDay = $date->day;
        if ($repeatType == self::TYPE_MONTHLY) {
            $date->addMonths($numMonthOrYear);
        } else {
            $date->addYears($numMonthOrYear);
        }
        if ($startDay != $date->day) {
            $date->modify('last day of last month');
        }
        return $date;
    }
}