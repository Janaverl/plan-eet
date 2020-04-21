<?php

namespace App\Controller;

use App\Entity\Camp;
use App\Service\ValidateRoute;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/shoppinglists")
 */
class ShoppinglistController extends AbstractController
{
     /**
     * @Route("/show/{slug}", name="shoppinglists_show")
     */
    public function show($slug, ValidateRoute $validateRoute)
    {
        // validation
        $this->denyAccessUnlessGranted('ROLE_USER');

        $camp = $this->getDoctrine()
            ->getRepository(Camp::class)
            ->findOneBy(['id' => $slug]);

        if (!empty($camp)) {        
            $isCreatedByUser = $validateRoute->isCreatedByUser($this->getUser(), $camp->getUser());
        }

        if (empty($camp) or !$isCreatedByUser) {
            return $this->redirectToRoute('camps_index', [
                'slug' => "future"
            ]);
        };

        // If passes validation:
        $entityManager = $this->getDoctrine()->getManager();

        $allIngredients = $entityManager->getRepository('App:Ingredient')
            ->findArrayByCamp($slug);

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
