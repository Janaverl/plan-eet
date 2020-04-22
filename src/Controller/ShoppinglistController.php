<?php

namespace App\Controller;

use App\Entity\Camp;
use App\Service\ValidateRoute;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ShoppinglistController extends AbstractController
{
    public function show($campid, ValidateRoute $validateRoute)
    {
        // validation
        $this->denyAccessUnlessGranted('ROLE_USER');

        $camp = $this->getDoctrine()
            ->getRepository(Camp::class)
            ->findOneBy(['id' => $campid]);

        if (!empty($camp)) {        
            $isCreatedByUser = $validateRoute->isCreatedByUser($this->getUser(), $camp->getUser());
        }

        if (empty($camp) or !$isCreatedByUser) {
            return $this->redirectToRoute('camps_index', [
                'time' => "future"
            ]);
        };

        // If passes validation:
        $entityManager = $this->getDoctrine()->getManager();

        $allIngredients = $entityManager->getRepository('App:Ingredient')
            ->findArrayByCamp($campid);

        dump($allIngredients);

        if ($allIngredients == []) {
            $message = "geen ingredienten toegevoegd voor dit kamp";
        } else {
            $message = "uw boodschappenlijstje:";
        }

        return $this->render('shoppinglist/individual.html.twig', [
            'message' => $message,
            'ingredients' => $allIngredients,
            'camp' => $camp,
        ]);
    }
}
