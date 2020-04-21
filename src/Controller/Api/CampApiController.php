<?php

namespace App\Controller\Api;

use App\Entity\Camp;
use App\Service\Addvalue;
use App\Service\CampServices;
use App\Service\Fullcalendar\Fullcalendar;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/camps")
 */
class CampApiController extends AbstractController
{
    /**
     * @param Request $request
     * @param Addvalue $addvalue
     * @param CampServices $campServices
     * @return Response
     * @Route("/store", name="camps_api_store", methods={"POST"})
     */
    public function store(Request $request, Addvalue $addvalue, CampServices $campServices): Response
    {
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
            $campServices->create_mealmoments($camp, $data["mealmoments"], $entityManager);
        }

        $campServices->create_campdays($camp, $data["startdate"], $data["enddate"], $entityManager);

        $response = new JsonResponse();
        $response->setData(['statuscode' => $addvalue->tryCatch($entityManager)]);

        return $response;
    }

    /**
     * @param Response
     * @return JsonResponse
     * @Route("/show/{slug}", name="camps_api_show", methods={"GET"})
     */
    public function show($slug, Request $request, Addvalue $addvalue, Fullcalendar $fullcalendar): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        
        // TODO: validateroute for API
        
        $camp = $this->getDoctrine()
            ->getRepository(Camp::class)
            ->findOneBy(['id' => $_GET["camp"]]);

        // define the entitymanager, because you will need to send data later in this API
        $entityManager = $this->getDoctrine()->getManager();

        // We need a clone of these Datetime-values, because we will modify this.
        $firstday = clone $camp->getStartTime();
        $lastday = clone $camp->getEndTime();

        $mealhours = $fullcalendar->create_businesshours($camp->getCampMealmoments(), 60);
        $dataWeWillSend = array(
            "start" => $firstday->format('Y-m-d'),
            "end" => $lastday->modify('+1 day')->format('Y-m-d'),
            "mealhours" => $mealhours->getValues()
        );

        $json = new JsonResponse();
        $json->setData($dataWeWillSend);

        return $json;
    }
}
