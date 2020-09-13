<?php

namespace App\Controller;

use App\Entity\Camp;
use App\Entity\Ingredient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ShoppinglistController extends AbstractController
{
    public function show(Camp $camp)
    {
        if (empty($camp)) {
            return $this->redirectToRoute('camps_index',
                ['time' => "future"]
            );
        };

        $this->denyAccessUnlessGranted('view', $camp);

        // If passes validation:
        $entityManager = $this->getDoctrine()->getManager();

        $allIngredients = $entityManager->getRepository(Ingredient::class)
            ->findArrayByCamp($camp);

        dump($allIngredients);

        if ($allIngredients == []) {
            $message = "geen ingredienten toegevoegd voor dit kamp";
        } else {
            $message = "uw boodschappenlijstje:";
        }

        return $this->render(
            'shoppinglist/individual.html.twig',
            [
                'message' => $message,
                'ingredients' => $allIngredients,
                'camp' => $camp,
            ]
        );
    }
}
