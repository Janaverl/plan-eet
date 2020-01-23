<?php

namespace App\Service;

use App\Service\Converttime;

class Fullcalendar
{
    protected $converttime;

    public function __construct(Converttime $converttime)
    {
        $this->converttime = $converttime;
    }
    public function create_businesshours(object $moments, int $durationInMinutes): array
    {
        $businesshours = [];
        foreach ($moments as $moment) {
            $timeStart = $moment->gettime();
            $timeEnd = $timeStart + 60;
            array_push($businesshours, [
                "daysOfWeek" => "[0, 1, 2, 3, 4, 5, 6]",
                "startTime" => $this->converttime->decimal_to_time($timeStart),
                "endTime" => $this->converttime->decimal_to_time($timeEnd),
            ]);
        }
        return $businesshours;
    }

    public function create_events(object $camp): array
    {
        $firstcampMoment = $camp->getStartTime();
        $lastcampMoment = $camp->getEndTime();

        $dateOfMeal = clone $camp->getStartTime();

        $daycount = 0;
        $allTheEvents = [];

        foreach ($camp->getCampdays() as $campday) {
            $dateOfMealInString = $dateOfMeal->format('Y-m-d');
            foreach ($camp->getCampMealmoments() as $mealmoment) {
                $oneEventThatNeedsToBeCreated = [];

                $timeStartOfMeal = $mealmoment->gettime();
                $timeEndOfMeal = $timeStartOfMeal + 60;

                $oneEventThatNeedsToBeCreated["start"] = $dateOfMealInString . 'T' . $this->converttime->decimal_to_time($timeStartOfMeal);
                $oneEventThatNeedsToBeCreated["end"] = $dateOfMealInString . 'T' . $this->converttime->decimal_to_time($timeEndOfMeal);

                $datetimeStartOfMeal = new \Datetime($dateOfMealInString . 'T' . $this->converttime->decimal_to_time($timeStartOfMeal));

                if ($datetimeStartOfMeal < $firstcampMoment || $lastcampMoment < $datetimeStartOfMeal) {
                    $oneEventThatNeedsToBeCreated["rendering"] = 'background';
                    $oneEventThatNeedsToBeCreated["className"] = 'fc-nonbusiness';
                } else {
                    $oneEventThatNeedsToBeCreated["title"] = $mealmoment->getMealmoment()->getName();
                    $oneEventThatNeedsToBeCreated["url"] = '/add/meal/' . $mealmoment->getMealmoment()->getName() . '?camp=' . $camp->getId() . '&day=' . $daycount;
                }
                array_push($allTheEvents, $oneEventThatNeedsToBeCreated);
            }
            $daycount++;
            $dateOfMeal->modify('+1 day');
        }
        return $allTheEvents;
    }
}
