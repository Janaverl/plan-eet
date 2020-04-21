<?php

namespace App\Service\Fullcalendar;

class MealEvent
{
    public $eventInformation;

    public function __construct($start, $end)
    {
        $this->eventInformation["start"] = $start;
        $this->eventInformation["end"] = $end;
    }

    public function makePassive()
    {
        $this->eventInformation["rendering"] = 'background';
        $this->eventInformation["className"] = 'fc-nonbusiness';
    }

    public function renderWithMeal($campmealName, $mealmomentname, $campid, $daycount){
        $this->eventInformation["extendedProps"] = array(
            "currentDaycount" => $daycount,
            "currentMealmoment" => $mealmomentname,
            "currentEventStart" => $this->eventInformation["start"],
            "hasMeal" => true
        );
        $this->eventInformation["title"] = $campmealName;
        $this->eventInformation["color"] = 'darkgrey';
        $this->eventInformation["url"] = '/campmeals/show/' . $mealmomentname . '?camp=' . $campid . '&day=' . $daycount;
    }

    public function renderWithoutMeal($mealmomentname, $campid, $daycount){
        $this->eventInformation["title"] = $mealmomentname;
        $this->eventInformation["color"] = '#1a252f';
        $this->eventInformation["url"] = '/campmeals/create/' . $mealmomentname . '?camp=' . $campid . '&day=' . $daycount;

    }

    public function getValues(){
        dump($this->eventInformation);
        return $this->eventInformation;
    }

}