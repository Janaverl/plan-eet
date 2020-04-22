<?php

namespace App\Controller;

use App\Entity\Herb;
use App\Entity\Ingredient;
use App\Entity\RecipeCategory;
use App\Entity\Recipes;
use App\Entity\RecipeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/recipes")
 */
class RecipeController extends AbstractController
{
    /**
     * @Route("/index", name="recipes_index")
     */
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

    /**
     * @Route("/create", name="recipes_create")
     */
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

    /**
     * @Route("/show/{slug}", name="recipes_show")
     */
    public function show($slug)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $recipe = $this->getDoctrine()
            ->getRepository(Recipes::class)
            ->findOneBy(['name' => $slug]);

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

    /**
     * @Route("/edit/{slug}", name="recipes_edit")
     */
    public function edit($slug)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $recipe = $this->getDoctrine()
            ->getRepository(Recipes::class)
            ->findOneBy(['name' => $slug]);

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
