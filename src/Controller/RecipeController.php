<?php

namespace App\Controller;

use App\Entity\Recipes;
use App\Entity\RecipeType;
use App\Entity\RecipeCategory;
use App\Entity\RecipeIngredients;
use App\Entity\Ingredient;
use App\Entity\RecipeHerb;
use App\Entity\Herb;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Service\Addvalue;

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
        
        $allHerbs = $this->getDoctrine()
        ->getRepository(Herb::class)
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
            'herbs' => $allHerbs,
        ]
        );
    }

     /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/fetch/add/recipe", name="fetch_add_recipe", methods={"POST"})
     */
    public function addAction(Request $request, Addvalue $addvalue) : Response {
        $data = json_decode($request->getContent(), true);

        // look for a single recipecategorie by name
        $category = $this->getDoctrine()
            ->getRepository(RecipeCategory::class)
            ->findOneBy(['name' => $data["category"]]);

        // look for a single recipetype by name
        $type = $this->getDoctrine()
            ->getRepository(RecipeType::class)
            ->findOneBy(['name' => $data["type"]]);

        // create the object for the new value
        $recipe = new Recipes();
        $recipe->setName($data["name"])
            ->setInstructions($data["instructions"])
            ->setCategory($category)
            ->setType($type);
        if(isset($data["suggestion"]) && $data["suggestion"] != ""){
            $recipe->setSuggestion($data["suggestion"]);
        };

        $entityManager = $this->getDoctrine()->getManager();
        // tell Doctrine you want to (eventually) save the Recipe (no queries yet)
        $entityManager->persist($recipe);

        if(isset($data["herbs"]) && $data["herbs"] != ""){
            // $recipe->setSuggestion($data["suggestion"]);
            foreach($data["herbs"] as $herb){

                // look for a single ingredientID by name
                $herb = $this->getDoctrine()
                    ->getRepository(Herb::class)
                    ->findOneBy(['name' => $herb]);
                
                $recipeHerb = new RecipeHerb();
                $recipeHerb->setHerb($herb);
                $recipeHerb->setRecipe($recipe);
                $entityManager->persist($recipeHerb);
            }
        };

        foreach($data["ingredients"] as $ingredient){
            $quantity = $ingredient["quantity"] / $data["numberOfEaters"];
            // look for a single ingredientID by name
            $ingr = $this->getDoctrine()
                ->getRepository(Ingredient::class)
                ->findOneBy(['name' => $ingredient["name"]]);
            
            $recipeIngredient = new RecipeIngredients();
            $recipeIngredient->setIngredient($ingr);
            $recipeIngredient->setRecipe($recipe);
            $recipeIngredient->setQuantity($quantity);
            $entityManager->persist($recipeIngredient);
        }

        $response = new JsonResponse();
        $response->setData(['statuscode' => $addvalue->tryCatch($entityManager, $recipe)]);
    
        return $response;
    }

    /**
     * @Route("/show/recepten", name="show_recipes")
     */
    public function show(){
        $this->denyAccessUnlessGranted('ROLE_USER');

        $allRecipes = $this->getDoctrine()
            ->getRepository(Recipes::class)
            ->findAll();

        // foreach ($allRecipes as $recipe) {
        //     // $recipe->getCategory()->getName();
        //     // $recipe->getType()->getName();
        //     // $ingredients = $recipe->getIngredients();
        //     // $herbs = $recipe->getRecipeHerb();
        //     // foreach ($herbs as $herb){
        //     //     $herb->getHerb()->getName();
        //     // }

        // };

        dump($allRecipes);

        return $this->render('recipe/show.html.twig', [
            'values' => $allRecipes,
        ]);
    }
}
