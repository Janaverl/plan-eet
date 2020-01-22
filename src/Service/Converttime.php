<?php

namespace App\Service;

class Converttime
{

    public function decimal_to_time($decimal)
    {
        $hours = floor((int) $decimal / 60);
        $minutes = floor((int) $decimal % 60);

        return str_pad($hours, 2, "0", STR_PAD_LEFT) . ":" . str_pad($minutes, 2, "0", STR_PAD_LEFT);
    }

    public function time_to_decimal($time)
    {
        $time = explode(':', $time);
        $minutes = ($time[0] * 60.0 + $time[1] * 1.0);

        return $minutes;
    }

}
