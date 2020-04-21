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
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/campmeals")
 */
class CampmealController extends AbstractController
{
     /**
     * This functions shows the recipes and ingredients that belongs to meals.
     * //TODO: button that redirects to a view to change a recipe
     * @Route("/show/{slug}", name="campmeals_show")
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
     * @Route("/create/{slug}", name="campmeals_create")
     */
    public function create($slug)
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

}
