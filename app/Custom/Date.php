<?php

namespace App\Custom;


class Date
{

    public static function toView($date)
    {
        $date = explode('-',$date);
        $year = $date[0];
        $month = $date[1];
        $day = $date[2];

        $data_format =  $day.'/'.$month.'/'.$year;
        return $data_format;
    }

    public static function toViewAndHour($date)
    {
        $dateF = explode(' ', $date);
        $dateFormat = explode('-',$dateF[0]);
        $year = $dateFormat[0];
        $month = $dateFormat[1];
        $day = $dateFormat[2];

        $data_format = $day.'/'.$month.'/'.$year;
        return $data_format;
    }

}