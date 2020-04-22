<?php

namespace App\Controller;

use App\Entity\Herb;
use App\Entity\Ingredient;
use App\Entity\RecipeCategory;
use App\Entity\Recipes;
use App\Entity\RecipeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RecipeController extends AbstractController
{
    public function index()
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $allRecipes = $this->getDoctrine()
            ->getRepository(Recipes::class)
            ->findAll();

        return $this->render('recipe/all.html.twig', [
            'values' => $allRecipes,
            'nrOfEaters' => 10,
        ]);
    }

    public function create()
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $allRecipes = $this->getDoctrine()
            ->getRepository(Recipes::class)
            ->findAll();

        $allCategories = $this->getDoctrine()
            ->getRepository(RecipeCategory::class)
            ->findAll();

        $allTypes = $this->getDoctrine()
            ->getRepository(RecipeType::class)
            ->findAll();

        $allIngredients = $this->getDoctrine()
            ->getRepository(Ingredient::class)
            ->findAll();

        $allHerbs = $this->getDoctrine()
            ->getRepository(Herb::class)
            ->findAll();

        return $this->render('recipe/individual.html.twig',
            [
                'values' => $allRecipes,
                'categories' => $allCategories,
                'types' => $allTypes,
                'ingredients' => $allIngredients,
                'herbs' => $allHerbs,
                'mode' => "add",
            ]
        );
    }

    public function show($recipename)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $recipe = $this->getDoctrine()
            ->getRepository(Recipes::class)
            ->findOneBy(['name' => $recipename]);

        if (empty($recipe)) {
            return $this->render('page/index.html.twig');
        }

        $entityManager = $this->getDoctrine()->getManager();
        $ingredients = $entityManager->getRepository('App:RecipeIngredients')
            ->findIngredientsSortedByRayon($recipe);

        return $this->render('recipe/individual.html.twig', [
            'value' => $recipe,
            'ingredients' => $ingredients,
            'nrOfEaters' => 10,
            'mode' => "show",
        ]);
    }

    public function edit($recipename)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $recipe = $this->getDoctrine()
            ->getRepository(Recipes::class)
            ->findOneBy(['name' => $recipename]);

        if (isset($recipe)) {
            $pageCanLoad = true;
        } else {
            $pageCanLoad = false;
        };

        if ($pageCanLoad) {
            $allCategories = $this->getDoctrine()
                ->getRepository(RecipeCategory::class)
                ->findAll();

            $allTypes = $this->getDoctrine()
                ->getRepository(RecipeType::class)
                ->findAll();

            $allIngredients = $this->getDoctrine()
                ->getRepository(Ingredient::class)
                ->findAll();

            $allHerbs = $this->getDoctrine()
                ->getRepository(Herb::class)
                ->findAll();

            return $this->render('recipe/individual.html.twig', [
                'value' => $recipe,
                'categories' => $allCategories,
                'types' => $allTypes,
                'ingredients' => $allIngredients,
                'herbs' => $allHerbs,
                'nrOfEaters' => 10,
                'mode' => "update",
            ]);
        } else {

            return $this->render('page/index.html.twig');

        }
    }

}
