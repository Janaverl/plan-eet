<?php

namespace App\Service;

use App\Entity\Campmeal;
use App\Service\Converttime;

/**
 * this class prepares the arrays with the fullcalendar.io-syntax,
 * so the javascript can hadle this information directly after receiving this data from the API
 */
class Fullcalendar
{
    protected $converttime;

    public function __construct(Converttime $converttime)
    {
        $this->converttime = $converttime;
    }
    /**
     * @param object $moments
     * @param integer $durationInMinutes
     * @return array
     */
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

    /**
     * @param object $camp
     * @return array
     */
    public function create_events(object $camp, object $entityManager): array
    {
        $firstcampMoment = $camp->getStartTime();
        $lastcampMoment = $camp->getEndTime();

        $campid = $camp->getId();

        $dateOfMeal = clone $camp->getStartTime();

        $allTheEvents = [];

        foreach ($camp->getCampdays() as $campday) {
            $daycount = $campday->getCampdaycount();
            $dateOfMeal = clone $camp->getStartTime();
            $dateOfMeal->modify('+' . $daycount . ' day');
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
                    $campmeal = $entityManager->getRepository(Campmeal::class)
                        ->findOneBy([
                            'campday' => $campday,
                            'campMealmoment' => $mealmoment,
                        ]);
                    if ($campmeal) {
                        $mealmomentname = $mealmoment->getMealmoment()->getName();
                        $oneEventThatNeedsToBeCreated["title"] = $campmeal->getName();
                        $oneEventThatNeedsToBeCreated["color"] = 'green';
                        $oneEventThatNeedsToBeCreated["extendedProps"]["oldDaycount"] = $daycount;
                        $oneEventThatNeedsToBeCreated["extendedProps"]["oldMealmoment"] = $mealmomentname;
                        $oneEventThatNeedsToBeCreated["url"] = '/show/meal/' . $mealmomentname . '?camp=' . $campid . '&day=' . $daycount;

                    } else {
                        $mealmomentname = $mealmoment->getMealmoment()->getName();
                        $oneEventThatNeedsToBeCreated["title"] = $mealmomentname;
                        $oneEventThatNeedsToBeCreated["extendedProps"]["oldDaycount"] = $daycount;
                        $oneEventThatNeedsToBeCreated["extendedProps"]["oldMealmoment"] = $mealmomentname;
                        $oneEventThatNeedsToBeCreated["url"] = '/add/meal/' . $mealmomentname . '?camp=' . $campid . '&day=' . $daycount;

                    }
                }
                array_push($allTheEvents, $oneEventThatNeedsToBeCreated);
            }
            // $daycount++;
        }
        return $allTheEvents;
    }
}
