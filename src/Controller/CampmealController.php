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
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CampmealController extends AbstractController
{
    public function show($mealmoment)
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
                'name' => $mealmoment
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
            ->findArrayByCampmeal($_GET["camp"], $mealmoment, $_GET["day"]);

        return $this->render('meal/show.html.twig', [
            'camp' => $camp,
            'courses' => $mealcourses,
            'ingredients' => $ingredients,
            'nrOfEaters' => $camp->getNrOfParticipants(),
        ]);

    }

    public function create($mealmoment)
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
            'meal' => $mealmoment,
            'campday' => $_GET["day"],
        ]);
    }

}
