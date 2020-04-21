<?php

namespace App\Controller;

use App\Entity\Camp;
use App\Entity\Campday;
use App\Entity\Campmeal;
use App\Entity\CampMealmoments;
use App\Entity\Ingredient;
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

class MealController extends AbstractController
{
    /**
     * This functions shows the recipes and ingredients that belongs to meals.
     * //TODO: button that redirects to a view to change a recipe
     * @Route("/show/meal/{slug}", name="show_meal")
     */
    public function show($slug)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        // define the entitymanager, because you will need to send data later in this API
        $entityManager = $this->getDoctrine()->getManager();

        $camp = $entityManager->getRepository(Camp::class)
            ->findOneBy([
                'id' => $_GET["camp"],
                'user' => $this->getUser(),
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
                'campdaycount' => $_GET["day"],
            ]);

        $campmeal = $entityManager->getRepository(Campmeal::class)
            ->findOneBy([
                'campMealmoment' => $campmealmoment,
                'campday' => $campday,
            ]);

        $mealcourses = $entityManager->getRepository(Mealcourse::class)
            ->findByCampmeal($campmeal);

        $ingredients = $this->getDoctrine()
            ->getRepository(Ingredient::class)
            ->findArrayByCampmeal($_GET["camp"], $slug, $_GET["day"]);

        return $this->render('meal/show.html.twig', [
            'camp' => $camp,
            'courses' => $mealcourses,
            'ingredients' => $ingredients,
            'nrOfEaters' => $camp->getNrOfParticipants(),
        ]);

    }

    /**
     * @Route("/add/meal/{slug}", name="add_meal")
     */
    public function add($slug)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $allRecipes = $this->getDoctrine()
            ->getRepository(Recipes::class)
            ->findAll();

        $camp = $this->getDoctrine()
            ->getRepository(Camp::class)
            ->findOneBy(['id' => $_GET["camp"]]);

        $campday = $_GET["day"];
        $startday = $camp->getStartTime();
        $mealday = $startday->modify('+' . $campday . ' day')->format('Y-m-d');

        return $this->render('meal/individual.html.twig', [
            'recipes' => $allRecipes,
            'camp' => $camp,
            'mealday' => $campday,
            'meal' => $slug,
            'campday' => $_GET["day"],
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/fetch/add/meal", name="fetch_add_meal", methods={"POST"})
     */
    public function addAction(Request $request, Addvalue $addvalue): Response
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

    
    /**
     * @param Response
     * @return JsonResponse
     * @Route("/fetch/show/meals/{slug}", name="fetch_show_meals", methods={"GET"})
     */
    public function fetchMeals($slug, Fullcalendar $fullcalendar, ValidateRoute $validateRoute): Response
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

}
