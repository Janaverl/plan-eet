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
use App\Service\Fullcalendar\Fullcalendar;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CampmealApiController extends ApiController
{
    /**
     * @param object $campmealmoment
     * @param object $campday
     * @param string $mealname
     * @param array $recipes
     * @param object $entityManager
     * @return void
     */
    protected function create_campmeal(object $campmealmoment, object $campday, string $mealname, array $recipes, object $entityManager): void
    {
        $campmeal = new Campmeal();
        $campmeal->setCampMealmoment($campmealmoment)
            ->setCampday($campday)
            ->setName($mealname);

        // tell Doctrine you want to (eventually) save, no queries yet
        $entityManager->persist($campmeal);

        // create a MealCourse-object for each recipe the user adds to his meal
        foreach ($recipes as $recipeId) {
            $recipe = $entityManager->getRepository(Recipes::class)
                ->findOneBy(['id' => str_replace("recipe", "", $recipeId),]);

            $mealcourse = new Mealcourse();
            $mealcourse->setRecipe($recipe)
                ->setCampmeal($campmeal);
            // tell Doctrine you want to (eventually) save, no queries yet
            $entityManager->persist($mealcourse);
        }
    }

    /**
     * @param Fullcalendar $fullcalendar
     * @return Response
     */
    public function index(Fullcalendar $fullcalendar): Response
    {
        $camp = $this->getDoctrine()
            ->getRepository(Camp::class)
            ->findOneBy(['id' => $_GET["camp"]]);
        
        $this->denyAccessUnlessGranted('view', $camp);
        $this->throwExceptionIfNotExcists($camp);

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
     */
    public function store(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $entityManager = $this->getDoctrine()->getManager();

        $camp = $entityManager->getRepository(Camp::class)
            ->findOneBy(['id' => $data["campid"],]);
        
        $this->denyAccessUnlessGranted('view', $camp);

        $mealmoment = $entityManager->getRepository(Mealmoment::class)
            ->findOneBy(['name' => $data["mealmoment"]]);

        $campmealmoment = $entityManager->getRepository(CampMealmoments::class)
            ->findOneBy(
                ['camp' => $camp,
                'mealmoment' => $mealmoment]
            );

        $campday = $entityManager->getRepository(Campday::class)
            ->findOneBy(
                ['camp' => $camp,
                'campdaycount' => $data["mealday"]]
            );
        
        $this->create_campmeal($campmealmoment, $campday, $data["name"], $data["recept"], $entityManager);

        $this->flushOrThrowException($entityManager);

        $response = new JsonResponse("success");

        return $response;
    }

}
