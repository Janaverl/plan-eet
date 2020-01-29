<?php

namespace App\Controller;

use App\Entity\Camp;
use App\Entity\Campday;
use App\Entity\Campmeal;
use App\Entity\CampMealmoments;
use App\Entity\Mealcourse;
use App\Entity\Mealmoment;
use App\Entity\Recipes;
use App\Service\Addvalue;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MealController extends AbstractController
{
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

        $campmealmoment = $entityManager->getRepository(CampMealmoments::class)
            ->findOneBy([
                'camp' => $camp,
                'mealmoment' => $this->getDoctrine()
                    ->getRepository(Mealmoment::class)
                    ->findOneBy([
                        'name' => $data["mealmoment"],
                    ]),
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
