<?php

namespace App\Controller;

use App\Entity\Camp;
use App\Entity\User;
use App\Entity\Mealmoment;
use App\Entity\CampMealmoments;
use App\Entity\CampDay;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\DateTime;

use App\Service\Addvalue;
use App\Service\Converttime;

class CampController extends AbstractController
{
    /**
     * @Route("/add/camp", name="add_camp")
     */
    public function add()
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

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
    public function addAction(Converttime $converttime, Request $request, Addvalue $addvalue) : Response {
        $data = json_decode($request->getContent(), true);

        $user = $this->getUser();
        $start = date_format(date_create($data["startdate"]." ".$data["starttime"]),"Y/m/d H:i:s");
        $end = date_format(date_create($data["enddate"]." ".$data["endtime"]),"Y/m/d H:i:s");
        $startTime = new \DateTime($start);
        $endTime = new \DateTime($end);

        // create the object for the new value
        $camp = new Camp();
        $camp->setName($data["name"])
            ->setStartTime($startTime)
            ->setEndTime($endTime)
            ->setNrOfParticipants($data["nrOfParticipants"])
            ->setUser($user);

        $entityManager = $this->getDoctrine()->getManager();
        // tell Doctrine you want to (eventually) save the Recipe (no queries yet)
        $entityManager->persist($camp);

        if(isset($data["mealmoment"]) && $data["mealmoment"] != ""){
            foreach($data["mealmoment"] as $mealmoment){
                $time = $converttime->time_to_decimal($mealmoment['time']);

                // look for a single mealmoment by name
                $mealmoment = $this->getDoctrine()
                    ->getRepository(Mealmoment::class)
                    ->findOneBy(['name' => $mealmoment["mealmoment"]]);
                $campMealmoment = new CampMealmoments();
                $campMealmoment->setCamp($camp)
                    ->setMealmoment($mealmoment)
                    ->setTime($minutes);
                $entityManager->persist($campMealmoment);
            }
        }

        $campdaycount = 0;
        $campdayOne = new \DateTime($start);
        for($i = $campdayOne; $i <= $endTime; $i->modify('+1 day')){
            $campday = new Campday();
            $campday->setCamp($camp)
                ->setCampdaycount($campdaycount);
            $entityManager->persist($campday);
            $campdaycount += 1;
        }

        $response = new JsonResponse();
        $response->setData(['statuscode' => $addvalue->tryCatch($entityManager)]);
    
        return $response;
    }

    
    
     /**
     * @Route("/update/camp/{slug}", name="update_camp")
     */
    public function updateAction($slug){
        // $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $camp = $this->getDoctrine()
            ->getRepository(Camp::class)
            ->findOneBy(['id' => $_GET["camp"]]);
        
        $entityManager = $this->getDoctrine()->getManager();

        if(!$camp){
            return $this->render('general/index.html.twig');
        }else if($camp->getName() != $slug){
            return $this->render('general/index.html.twig');
        }else{ 
            return $this->render('camp/callenderindividual.html.twig', [
                'value' => $camp,
            ]);
        }
    }
       
     /**
     * @param Response
     * @return JsonResponse
     * @Route("/fetch/update/camp/{slug}", name="fetch_update_camp", methods={"GET"})
     */
    public function fetchUpdateAction($slug, Converttime $converttime, Request $request, Addvalue $addvalue) : Response {
        $data = [];
        
        $camp = $this->getDoctrine()
            ->getRepository(Camp::class)
            ->findOneBy(['id' => $_GET["camp"]]);

        $data["start"] = $camp->getStartTime()->format('Y-m-d');
        $endday = clone $camp->getEndTime();
        $data["end"] = $endday->modify('+1 day')->format('Y-m-d');
        
        $mealmoments = $camp->getCampMealmoments();

        $data["mealhours"] = [];

        foreach($mealmoments as $mealmoment){
            $timeStart = $mealmoment->gettime();
            $timeEnd = $timeStart + 60;
            array_push($data["mealhours"], [
                "daysOfWeek" => "[0, 1, 2, 3, 4, 5, 6]",
                "startTime" => $converttime->decimal_to_time($timeStart),
                "endTime" => $converttime->decimal_to_time($timeEnd)
            ]);
        }

        $data["allthemeals"] = [];

        $firstcampMoment = clone $camp->getStartTime();
        $lastcampMoment = $camp->getEndTime();

        $day = 0;

        for($i = $firstcampMoment; $i <= $lastcampMoment; $i->modify('+1 day')){
            $date = $i->format('Y-m-d');
            foreach($mealmoments as $mealmoment){
                $timeStart = $mealmoment->gettime();
                $timeEnd = $timeStart + 60;
                $mealTimeStart = new \Datetime($date.'T'.$converttime->decimal_to_time($timeStart));
                if($mealTimeStart < $camp->getStartTime()){
                    array_push($data["allthemeals"], [
                        "rendering" => 'background',
                        "className" => 'fc-nonbusiness',
                        "start" => $date.'T'.$converttime->decimal_to_time($timeStart),
                        "end" => $date.'T'.$converttime->decimal_to_time($timeEnd)
                    ]);
                } else if($lastcampMoment < $mealTimeStart){
                    array_push($data["allthemeals"], [
                        "rendering" => 'background',
                        "className" => 'fc-nonbusiness',
                        "start" => $date.'T'.$converttime->decimal_to_time($timeStart),
                        "end" => $date.'T'.$converttime->decimal_to_time($timeEnd)
                    ]);
                }else{
                    array_push($data["allthemeals"], [
                        "title" => $mealmoment->getMealmoment()->getName(),
                        "start" => $date.'T'.$converttime->decimal_to_time($timeStart),
                        "end" => $date.'T'.$converttime->decimal_to_time($timeEnd),
                        "url" => '/add/meal/'.$mealmoment->getMealmoment()->getName().'?camp='.$camp->getId().'&day='.$day
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
    public function showall(){
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
