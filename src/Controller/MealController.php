<?php

namespace App\Controller;

use App\Entity\Recipes;
use App\Entity\Campmeal;
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

use App\Service\Addvalue;

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

        $startday = $camp->getStartTime();
        $mealday = $startday->modify('+'.$_GET["day"].' day')->format('Y-m-d');
        $campday = $_GET["day"];

        return $this->render('meal/individual.html.twig', [
            'recipes' => $allRecipes,
            'camp' => $camp,
            'mealday' => $mealday,
            'meal' => $slug,
            'campday' => $_GET["day"],
        ]);
    }

    
     /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/fetch/add/meal", name="fetch_add_meal", methods={"POST"})
     */
    public function addAction(Request $request, Addvalue $addvalue) : Response {
        $data = json_decode($request->getContent(), true);

        // API TODO

        $response = new JsonResponse();
        $response->setData(['statuscode' => $addvalue->tryCatch($entityManager)]);
    
        return $response;
    }
}
