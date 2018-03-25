<?php

namespace App\Services;

class DateTimeService
{
    public function __construct()
    {
    }

    public function getDayOfWeek($date){
        $days = array('Cn','Th 2','Th 3','Th 4','Th 5','Th 6','Th 7');
        $dayofweek = date('w', strtotime($date));
        return $days[$dayofweek];
    }

    /**
     * @param $date ( 2018/03/25 )
     *
     * @Description This function are use get all days of week
     * @return array
     */
    public function getAllDayOfWeek($date)
    {
        $d = date('N', strtotime($date));
        $week = array();
        for ($i = 1; $i < $d; ++$i) {
            $dateTime = new DateTime($date);
            for ($j = 0; $j < $i; ++$j) {
                $dateTime->modify('-1 day');
            }
            $week[] = $dateTime;
        }

        $week[] = new DateTime($date);
        for ($i = $d + 1; $i <= 7; ++$i) {
            $dateTime = new DateTime($date);
            for ($j = 0; $j < $i - $d; ++$j) {
                $dateTime->modify('+1 day');
            }
            $week[] = $dateTime;
        }

        sort($week);

        return $week;
    }

    /**
     * @param $year
     * @param $month
     *
     * @Description This function are use get all days of month
     *
     * @return array
     */
    public function getAllDayOfMonth($year, $month)
    {

        $list = array();

        for ($d = 1; $d <= 31; $d++) {
            $time = mktime(12, 0, 0, $month, $d, $year);
            if (date('m', $time) == $month)
                $list[] = date('Y-m-d-D', $time);
        }

        return $list;
    }


}