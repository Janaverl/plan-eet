<?php

namespace App\Service;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @return object
     */
    public function create_businesshours(object $moments, int $durationInMinutes): object
    {
        $businesshours = new ArrayCollection;

        foreach ($moments as $moment) {
            $timeStart = $moment->gettime();
            $timeEnd = $timeStart + $durationInMinutes;
            $timeBlockForMeal = [
                "daysOfWeek" => "[0, 1, 2, 3, 4, 5, 6]",
                "startTime" => $this->converttime->decimal_to_time($timeStart),
                "endTime" => $this->converttime->decimal_to_time($timeEnd),
            ];
            $businesshours->add($timeBlockForMeal);
        }

        return $businesshours;
    }

    /**
     * @param object $camp
     * @param object $entityManager
     * @return object
     */
    public function create_events(object $camp, object $entityManager): object
    {
        $firstcampMoment = $camp->getStartTime();
        $lastcampMoment = $camp->getEndTime();

        $campid = $camp->getId();

        $dateOfMeal = clone $camp->getStartTime();

        $allTheEvents = new ArrayCollection;

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

                    $allTheEvents->add($oneEventThatNeedsToBeCreated);
                    continue;
                }

                $campmeal = $entityManager->getRepository(Campmeal::class)
                    ->findOneBy([
                        'campday' => $campday,
                        'campMealmoment' => $mealmoment,
                    ]);
                
                $mealmomentname = $mealmoment->getMealmoment()->getName();
                $oneEventThatNeedsToBeCreated["extendedProps"]["oldDaycount"] = $daycount;
                $oneEventThatNeedsToBeCreated["extendedProps"]["oldMealmoment"] = $mealmomentname;
                
                
                if ($campmeal) {
                    $oneEventThatNeedsToBeCreated["title"] = $campmeal->getName();
                    $oneEventThatNeedsToBeCreated["color"] = 'darkgrey';
                    $oneEventThatNeedsToBeCreated["url"] = '/show/meal/' . $mealmomentname . '?camp=' . $campid . '&day=' . $daycount;

                    $allTheEvents->add($oneEventThatNeedsToBeCreated);
                    continue;
                }

                $oneEventThatNeedsToBeCreated["title"] = $mealmomentname;
                $oneEventThatNeedsToBeCreated["color"] = '#1a252f';
                $oneEventThatNeedsToBeCreated["url"] = '/add/meal/' . $mealmomentname . '?camp=' . $campid . '&day=' . $daycount;

                $allTheEvents->add($oneEventThatNeedsToBeCreated);
            }
        }

        return $allTheEvents;
    }
}
