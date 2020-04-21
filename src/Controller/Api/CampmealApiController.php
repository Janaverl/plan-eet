<?php

namespace App\Controller\Api;

use App\Entity\Camp;
use App\Entity\Campday;
use App\Entity\Campmeal;
use App\Entity\CampMealmoments;
use App\Entity\Mealcourse;
use App\Entity\Mealmoment;
use App\Entity\Recipes;
use App\Service\Addvalue;
use App\Service\ValidateRoute;
use App\Service\Fullcalendar\Fullcalendar;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/campmeals")
 */
class CampmealApiController extends AbstractController
{
    /**
     * @param Response
     * @return JsonResponse
     * @Route("/index/{slug}", name="campmeals_api_index", methods={"GET"})
     */
    public function index($slug, Fullcalendar $fullcalendar, ValidateRoute $validateRoute): Response
    {

        $this->denyAccessUnlessGranted('ROLE_USER');

        $camp = $this->getDoctrine()
            ->getRepository(Camp::class)
            ->findOneBy(['id' => $_GET["camp"]]);

        if (empty($camp)) {
            return new JsonResponse(['status'=>false, 'message' => 'not found'], 404);
        }
   
        if (!$validateRoute->isCreatedByUser($this->getUser(), $camp->getUser())) {
            return new JsonResponse(['status'=>false, 'message' => 'unauthorized'], 401);
        }

        if (!$validateRoute->hasMatchingSlug($slug, $camp->getName())) {
            return new JsonResponse(['status'=>false, 'message' => 'bad request'], 409);
        }

        // define the entitymanager, because you will need to send data later in this API
        $entityManager = $this->getDoctrine()->getManager();

        $allEvents = $fullcalendar->create_events($camp, $entityManager);

        $dataWeWillSend = $allEvents->getValues();

        $json = new JsonResponse();
        $json->setData($dataWeWillSend);

        return $json;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/store", name="campmeals_api_store", methods={"POST"})
     */
    public function store(Request $request, Addvalue $addvalue): Response
    {
        $data = json_decode($request->getContent(), true);

        // define the entitymanager, because you will need to send data later in this API
        $entityManager = $this->getDoctrine()->getManager();

        // collect all the data to create the new campMeal-object
        $camp = $entityManager->getRepository(Camp::class)
            ->findOneBy([
                'id' => $data["campid"],
            ]);

        $mealmoment = $entityManager->getRepository(Mealmoment::class)
            ->findOneBy([
                'name' => $slug
            ]);

        $campmealmoment = $entityManager->getRepository(CampMealmoments::class)
            ->findOneBy([
                'camp' => $camp,
                'mealmoment' => $mealmoment,
            ]);

        $campday = $entityManager->getRepository(Campday::class)
            ->findOneBy([
                'camp' => $camp,
                'campdaycount' => $data["mealday"],
            ]);

        $campmeal = new Campmeal();
        $campmeal->setCampMealmoment($campmealmoment)
            ->setCampday($campday)
            ->setName($data["name"]);

        // tell Doctrine you want to (eventually) save, no queries yet
        $entityManager->persist($campmeal);

        // create a MealCourse-object for each recipe the user adds to his meal
        foreach ($data["recept"] as $recipeId) {
            $recipe = $entityManager->getRepository(Recipes::class)
                ->findOneBy([
                    'id' => str_replace("recipe", "", $recipeId),
                ]);
            $mealcourse = new Mealcourse();
            $mealcourse->setRecipe($recipe)
                ->setCampmeal($campmeal);
            // tell Doctrine you want to (eventually) save, no queries yet
            $entityManager->persist($mealcourse);
        }

        $response = new JsonResponse();
        $response->setData(['statuscode' => $addvalue->tryCatch($entityManager)]);

        return $response;
    }

}
