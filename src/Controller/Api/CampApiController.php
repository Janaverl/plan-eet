<?php

namespace App\Controller\Api;

use App\Entity\Camp;
use App\Entity\CampDay;
use App\Entity\CampMealmoments;
use App\Entity\Mealmoment;
use App\Service\Addvalue;
use App\Service\CampServices;
use App\Service\Converttime;
use App\Service\Fullcalendar\Fullcalendar;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CampApiController extends ApiController
{
    /**
     * @param object $camp
     * @param string $mealmoments
     * @param object $entityManager
     * @return void
     */
    protected function create_mealmoments(object $camp, array $mealmoments = [], object $entityManager, $converttime): void
    {
        foreach ($mealmoments as $mealmoment) {
            $time = $converttime->time_to_decimal($mealmoment['time']);

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

        /**
     * @param object $camp
     * @param string $firstday
     * @param string $lastday
     * @param object $entityManager
     * @return void
     */
    protected function create_campdays(object $camp, string $firstday, string $lastday, object $entityManager): void
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

    /**
     * @param Request $request
     * @param Addvalue $addvalue
     * @param CampServices $campServices
     * @return Response
     */
    public function store(Request $request, Converttime $converttime): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $data = json_decode($request->getContent(), true);

        // define the entitymanager, because you will need to send data later in this API
        $entityManager = $this->getDoctrine()->getManager();

        // collect all the data needed and process it, so it can be send to the database
        $user = $this->getUser();

        $start = date_format(date_create($data["startdate"] . " " . $data["starttime"]), "Y/m/d H:i:s");
        $end = date_format(date_create($data["enddate"] . " " . $data["endtime"]), "Y/m/d H:i:s");
        $startTime = new \DateTime($start);
        $endTime = new \DateTime($end);

        // create the object for the new camp and set all his variables
        $camp = new Camp();

        $camp->setName($data["name"])
            ->setStartTime($startTime)
            ->setEndTime($endTime)
            ->setNrOfParticipants($data["nrOfParticipants"])
            ->setUser($user);

        // tell Doctrine you want to (eventually) save the camp (no queries yet)
        $entityManager->persist($camp);

        if (!empty($data["mealmoments"])) {
            $this->create_mealmoments($camp, $data["mealmoments"], $entityManager, $converttime);
        }

        $this->create_campdays($camp, $data["startdate"], $data["enddate"], $entityManager);

        $this->flushOrThrowException($entityManager);

        $response = new JsonResponse("success");

        return $response;
    }

    /**
     * @param string $campname
     * @param Request $request
     * @param Addvalue $addvalue
     * @param Fullcalendar $fullcalendar
     * @return Response
     */
    public function show($campid, Fullcalendar $fullcalendar): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $camp = $this->getDoctrine()
            ->getRepository(Camp::class)
            ->findOneBy(['id' => $campid]);

        $this->throwExceptionIfNotExcists($camp);
        $this->throwExceptionIfUnauthorizedUser($camp);

        // We need a clone of these Datetime-values, because we will modify this.
        $firstday = clone $camp->getStartTime();
        $lastday = clone $camp->getEndTime();

        $mealhours = $fullcalendar->create_businesshours($camp->getCampMealmoments(), 60);
        $dataWeWillSend = array(
            "start" => $firstday->format('Y-m-d'),
            "end" => $lastday->modify('+1 day')->format('Y-m-d'),
            "mealhours" => $mealhours->getValues()
        );

        $json = new JsonResponse($dataWeWillSend, 200);

        return $json;
    }
}
