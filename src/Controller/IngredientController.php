<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Entity\Rayon;
use App\Entity\Unit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IngredientController extends AbstractController
{
    public function index()
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $allIngredients = $this->getDoctrine()
            ->getRepository(Ingredient::class)
            ->findAll();

        return $this->render('ingredient/all.html.twig', [
            'values' => $allIngredients,
        ]);
    }

    public function create()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $allIngredients = $this->getDoctrine()
            ->getRepository(Ingredient::class)
            ->findAll();

        $allUnits = $this->getDoctrine()
            ->getRepository(Unit::class)
            ->findAll();

        $allRayons = $this->getDoctrine()
            ->getRepository(Rayon::class)
            ->findAll();

        return $this->render('ingredient/individual.html.twig', [
            'values' => $allIngredients,
            'rayons' => $allRayons,
            'units' => $allUnits,
            'mode' => "add",
        ]);
    }

    public function edit($ingredientname)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $ingredient = $this->getDoctrine()
            ->getRepository(Ingredient::class)
            ->findOneBy(['name' => $ingredientname]);

        if (empty($ingredient)) {
            return $this->redirectToRoute('ingredients_index');
        };

        $allRayons = $this->getDoctrine()
            ->getRepository(Rayon::class)
            ->findAll();

        $allUnits = $this->getDoctrine()
            ->getRepository(Unit::class)
            ->findAll();

        return $this->render('ingredient/individual.html.twig', [
            'value' => $ingredient,
            'rayons' => $allRayons,
            'units' => $allUnits,
            'mode' => "update",
        ]);
    }

}
