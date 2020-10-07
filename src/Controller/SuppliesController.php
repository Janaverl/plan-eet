<?php

namespace App\Controller;

use App\Entity\Camp;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SuppliesController extends AbstractController
{
    public function show(Camp $camp)
    {
        if (empty($camp)) {
            return $this->redirectToRoute(
                'camps_index',
                ['time' => "future"]
            );
        };

        $this->denyAccessUnlessGranted('view', $camp);

        return $this->render(
            'shoppinglist/individual.html.twig',
            [
                'camp' => $camp
            ]
        );
    }
}
