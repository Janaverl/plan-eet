<?php

namespace App\Controller;

use App\Entity\Recipes;
use App\Entity\RecipeType;
use App\Entity\RecipeCategory;
use App\Entity\Ingredient;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class RecipeController extends AbstractController{
    
    /**
     * @Route("/add/recipe", name="add_recipe")
     */
    public function add(){
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

        foreach ($allIngredients as $ingredient) {
                $ingredient->getUnit()->getName();
        };

        return $this->render('recipe/add.html.twig',
        [
            'values' => $allRecipes,
            'categories' => $allCategories,
            'types' => $allTypes,
            'ingredients' => $allIngredients,
        ]
        );
    }

}
