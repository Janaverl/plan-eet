<?php

namespace App\Service;

use App\Entity\CampDay;
use App\Entity\CampMealmoments;
use App\Entity\Mealmoment;
use App\Service\Converttime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints\DateTime;

class CampServices extends AbstractController
{
    protected $converttime;

    public function __construct(Converttime $converttime)
    {
        $this->converttime = $converttime;
    }
    public function create_mealmoments(object $camp, $mealmoments = "", $entityManager): void
    {
        foreach ($mealmoments as $mealmoment) {
            $time = $this->converttime->time_to_decimal($mealmoment['time']);

            // look for a single mealmoment by name
            $mealmoment = $this->getDoctrine()
                ->getRepository(Mealmoment::class)
                ->findOneBy(['name' => $mealmoment["mealmoment"]]);

            $campMealmoment = new CampMealmoments();
            $campMealmoment->setCamp($camp)
                ->setMealmoment($mealmoment)
                ->setTime($time);

            // tell Doctrine you want to (eventually) save the campmealmoment (no queries yet)
            $entityManager->persist($campMealmoment);
        }
    }
    public function create_campdays(object $camp, string $firstday, string $lastday, $entityManager): void
    {
        $campdaycount = 0;

        $start = date_format(date_create($firstday), "Y/m/d");
        $end = date_format(date_create($lastday), "Y/m/d");

        $campdayOne = new \DateTime($start);
        $campdayLast = new \DateTime($end);

        for ($date = $campdayOne; $date <= $campdayLast; $date->modify('+1 day')) {
            $campday = new Campday();
            $campday->setCamp($camp)
                ->setCampdaycount($campdaycount);

            $entityManager->persist($campday);
            $campdaycount += 1;
        }
    }
}
