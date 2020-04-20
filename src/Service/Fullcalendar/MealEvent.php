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

    public function makeActive($daycount, $mealmomentname)
    {
        $this->eventInformation["extendedProps"] = array(
            "oldDaycount" => $daycount,
            "oldMealmoment" => $mealmomentname
        );
    }

    public function renderWithMeal($campmealName, $mealmomentname, $campid, $daycount){
        $this->eventInformation["title"] = $campmealName;
        $this->eventInformation["color"] = 'darkgrey';
        $this->eventInformation["url"] = '/show/meal/' . $mealmomentname . '?camp=' . $campid . '&day=' . $daycount;
    }

    public function renderWithoutMeal($mealmomentname, $campid, $daycount){
        $this->eventInformation["title"] = $mealmomentname;
        $this->eventInformation["color"] = '#1a252f';
        $this->eventInformation["url"] = '/add/meal/' . $mealmomentname . '?camp=' . $campid . '&day=' . $daycount;

    }

    public function getValues(){
        dump($this->eventInformation);
        return $this->eventInformation;
    }




}