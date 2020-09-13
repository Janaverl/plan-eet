<?php

namespace App\Service\Fullcalendar;

use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Campmeal;
use App\Service\Converttime;
use App\Service\Fullcalendar\MealEvent;

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

    private function createOneMealEvent($entityManager, $campday, $mealmoment, $firstcampMoment, $lastcampMoment, $campid, $daycount, $currentDay)
    {
        $mealMomentTime = $mealmoment->gettime();
        $mealMomentName = $mealmoment->getMealMoment()->getName();

        $startMeal = $this->converttime->time_to_ISO8601($currentDay, $mealMomentTime);
        $endMeal = $this->converttime->time_to_ISO8601($currentDay, $mealMomentTime + 60);

        $oneEventThatNeedsToBeCreated = new MealEvent($startMeal, $endMeal);

        $startMeal = new \Datetime($startMeal);

        if ($startMeal < $firstcampMoment || $lastcampMoment < $startMeal) {
            $oneEventThatNeedsToBeCreated->makePassive();
            return $oneEventThatNeedsToBeCreated;
        }

        $campmeal = $entityManager->getRepository(Campmeal::class)
            ->findOneBy([
                'campday' => $campday,
                'campMealMoment' => $mealmoment,
            ]);
        
        if ($campmeal) {
            $oneEventThatNeedsToBeCreated->renderWithMeal($campmeal->getName(), $mealMomentName, $campid, $daycount);
            return $oneEventThatNeedsToBeCreated;
        }

        $oneEventThatNeedsToBeCreated->renderWithoutMeal($mealMomentName, $campid, $daycount);
        return $oneEventThatNeedsToBeCreated;
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

        $allTheEvents = new ArrayCollection;

        foreach ($camp->getCampdays() as $campday) {
            $daycount = $campday->getCampdaycount();
            $firstday = clone $camp->getStartTime();
            $currentDay = $firstday->modify('+' . $daycount . ' day')->format('Y-m-d');

            foreach ($camp->getCampMealMoments() as $mealmoment) {
                $oneMeal = $this->createOneMealEvent($entityManager, $campday, $mealmoment, $firstcampMoment, $lastcampMoment, $campid, $daycount, $currentDay);
                $allTheEvents->add($oneMeal->getValues());
            }

        }

        return $allTheEvents;
    }
}
