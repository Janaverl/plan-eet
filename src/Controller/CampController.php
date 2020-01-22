<?php

namespace App\Controller;

use App\Entity\Camp;
use App\Entity\Mealmoment;
use App\Service\Addvalue;
use App\Service\CampServices;
use App\Service\Converttime;
use App\Service\ValidateRoute;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;

class CampController extends AbstractController
{
    /**
     * @Route("/add/camp", name="add_camp")
     */
    public function add()
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        // get all mealmoments, so the user can select them and add them to the camp he is creating
        $allMealmoments = $this->getDoctrine()
            ->getRepository(Mealmoment::class)
            ->findAll();

        return $this->render('camp/individual.html.twig', [
            'mealmoments' => $allMealmoments,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/fetch/add/camp", name="fetch_add_camp", methods={"POST"})
     */
    public function addAction(Converttime $converttime, Request $request, Addvalue $addvalue, CampServices $campServices): Response
    {
        $data = json_decode($request->getContent(), true);

        // define the entitymanager, because you will need to send data later in this API
        $entityManager = $this->getDoctrine()->getManager();

        // collect all the data needed to process and send to the database
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

        if (isset($data["mealmoments"])) {
            $campServices->create_mealmoments($camp, $data["mealmoments"], $converttime, $entityManager);
        }

        $campServices->create_campdays($camp, $data["startdate"], $data["enddate"], $entityManager);

        $response = new JsonResponse();
        $response->setData(['statuscode' => $addvalue->tryCatch($entityManager)]);

        return $response;
    }

    /**
     * @Route("/update/camp/{slug}", name="update_camp")
     */
    public function updateAction($slug, ValidateRoute $validateRoute)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $user = $this->getUser();

        $camp = $this->getDoctrine()
            ->getRepository(Camp::class)
            ->findOneBy(['id' => $_GET["camp"]]);

        if (isset($camp)) {
            if ($validateRoute->has_matching_slug($slug, $camp->getName()) && $validateRoute->is_created_by_user($this->getUser(), $camp->getUser())) {
                $pageCanLoad = true;
            } else {
                $pageCanLoad = false;
            }
        } else {
            $pageCanLoad = false;
        };

        if ($pageCanLoad) {
            return $this->render('camp/callenderindividual.html.twig', [
                'value' => $camp,
            ]);
        } else {
            return $this->render('general/index.html.twig');
        }
    }

    /**
     * @param Response
     * @return JsonResponse
     * @Route("/fetch/update/camp/{slug}", name="fetch_update_camp", methods={"GET"})
     */
    public function fetchUpdateAction($slug, Converttime $converttime, Request $request, Addvalue $addvalue): Response
    {
        $data = [];

        $camp = $this->getDoctrine()
            ->getRepository(Camp::class)
            ->findOneBy(['id' => $_GET["camp"]]);

        $data["start"] = $camp->getStartTime()->format('Y-m-d');
        $endday = clone $camp->getEndTime();
        $data["end"] = $endday->modify('+1 day')->format('Y-m-d');

        $mealmoments = $camp->getCampMealmoments();

        $data["mealhours"] = [];

        foreach ($mealmoments as $mealmoment) {
            $timeStart = $mealmoment->gettime();
            $timeEnd = $timeStart + 60;
            array_push($data["mealhours"], [
                "daysOfWeek" => "[0, 1, 2, 3, 4, 5, 6]",
                "startTime" => $converttime->decimal_to_time($timeStart),
                "endTime" => $converttime->decimal_to_time($timeEnd),
            ]);
        }

        $data["allthemeals"] = [];

        $firstcampMoment = clone $camp->getStartTime();
        $lastcampMoment = $camp->getEndTime();

        $day = 0;

        for ($i = $firstcampMoment; $i <= $lastcampMoment; $i->modify('+1 day')) {
            $date = $i->format('Y-m-d');
            foreach ($mealmoments as $mealmoment) {
                $timeStart = $mealmoment->gettime();
                $timeEnd = $timeStart + 60;
                $mealTimeStart = new \Datetime($date . 'T' . $converttime->decimal_to_time($timeStart));
                if ($mealTimeStart < $camp->getStartTime()) {
                    array_push($data["allthemeals"], [
                        "rendering" => 'background',
                        "className" => 'fc-nonbusiness',
                        "start" => $date . 'T' . $converttime->decimal_to_time($timeStart),
                        "end" => $date . 'T' . $converttime->decimal_to_time($timeEnd),
                    ]);
                } else if ($lastcampMoment < $mealTimeStart) {
                    array_push($data["allthemeals"], [
                        "rendering" => 'background',
                        "className" => 'fc-nonbusiness',
                        "start" => $date . 'T' . $converttime->decimal_to_time($timeStart),
                        "end" => $date . 'T' . $converttime->decimal_to_time($timeEnd),
                    ]);
                } else {
                    array_push($data["allthemeals"], [
                        "title" => $mealmoment->getMealmoment()->getName(),
                        "start" => $date . 'T' . $converttime->decimal_to_time($timeStart),
                        "end" => $date . 'T' . $converttime->decimal_to_time($timeEnd),
                        "url" => '/add/meal/' . $mealmoment->getMealmoment()->getName() . '?camp=' . $camp->getId() . '&day=' . $day,
                    ]);
                }
            }
            $day++;
        }

        $json = new JsonResponse();
        $json->setData(json_encode($data));
        return $json;
    }

    /**
     * @Route("/show/camps", name="show_camps")
     */
    public function showall()
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $user = $this->getUser();

        $entityManager = $this->getDoctrine()->getManager();

        $allCamps = $entityManager->getRepository('App:Camp')
            ->findAllCampsByUser($user);

        return $this->render('camp/all.html.twig', [
            'values' => $allCamps,
        ]);
    }
}
