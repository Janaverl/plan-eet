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

class MealController extends AbstractController
{
    /**
     * @Route("/add/meal/{slug}", name="add_meal")
     */
    public function add()
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $allRecipes = $this->getDoctrine()
            ->getRepository(Recipes::class)
            ->findAll();

        return $this->render('meal/individual.html.twig', [
            'values' => $allRecipes,
        ]);
    }
}
