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
    public function addAction(Request $request, Addvalue $addvalue) : Response {
        $data = json_decode($request->getContent(), true);

        $user = $this->getUser();
        $startTime = date_format(date_create($data["startdate"]." ".$data["starttime"]),"Y/m/d H:i:s");
        $endTime = date_format(date_create($data["enddate"]." ".$data["endtime"]),"Y/m/d H:i:s");
        $startTime = new \DateTime($startTime);
        $endTime = new \DateTime($endTime);

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
                $time = explode(':', $mealmoment['time']);
                $minutes = ($time[0] * 60.0 + $time[1] * 1.0);

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
        for($i = $startTime; $i <= $endTime; $i->modify('+1 day')){
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
