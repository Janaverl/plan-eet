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

                // look for a single herb by name
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
     * @Route("/update/recept/{slug}", name="update_recipe")
     */
    public function update($slug){
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $recipe = $this->getDoctrine()
            ->getRepository(Recipes::class)
            ->findOneBy(['name' => $slug]);

        if(!$recipe){
            return $this->render('general/index.html.twig');
        }else{
            // $recipe->getRayon()->getName();

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
        }
    }

     /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/fetch/update/recipe", name="fetch_update_recipe", methods={"POST"})
     */
    public function updateAction(Request $request, Addvalue $addvalue) : Response {
        $data = json_decode($request->getContent(), true);

        // look for the recipe by name
        $recipe = $this->getDoctrine()
            ->getRepository(Recipes::class)
            ->findOneBy(['name' => $data["name"]]);
        
        $entityManager = $this->getDoctrine()->getManager();
        
        // check if the category changed
        if($recipe->getCategory()->getName() != $data["category"]){
            // look for a single recipecategorie by name
            $category = $this->getDoctrine()
                ->getRepository(RecipeCategory::class)
                ->findOneBy(['name' => $data["category"]]);
            $recipe->setCategory($category);
        };

        // check if the type changed
        if($recipe->getType()->getName() != $data["type"]){
            // look for a single recipetype by name
            $type = $this->getDoctrine()
                ->getRepository(RecipeType::class)
                ->findOneBy(['name' => $data["type"]]);
            $recipe->setType($type);
        };

        if($recipe->getInstructions() != $data["instructions"]){
            $recipe->setInstructions($data["instructions"]);
        }

        if(!isset($data["suggestion"])){
            $recipe->setSuggestion("");
        }elseif ($recipe->getSuggestion() != $data["suggestion"]){
                $recipe->setSuggestion($data["suggestion"]);
        }

        // ------------
        // UPDATE HERBS

        // search for all the herbs that are in the database for this recipe
        $allHerbsOld = $recipe->getRecipeHerb();

        // first, let's compare the old herbs with the new herbs, and check wich one we need to DELETE
        foreach($allHerbsOld as $herbOld){
            $todelete = TRUE;
            foreach($data["herbs"] as $herbNew){
                if($herbNew == $herbOld->getHerb()->getName()){
                    $todelete = FALSE;
                }
            }
            if($todelete === TRUE){
                $entityManager->remove($herbOld);
            }
        }

        // after that, let's compare the new herbs with the old herbs, and check wich one we need to ADD
        if(isset($data["herbs"])){
            foreach($data["herbs"] as $herbNew){
                $toadd = TRUE;
                foreach($allHerbsOld as $herbOld){
                    if($herbNew == $herbOld->getHerb()->getName()){
                        $toadd = FALSE;
                    }
                }
                if($toadd === TRUE){
                    // look for a single ingredientID by name
                    $herb = $this->getDoctrine()
                        ->getRepository(Herb::class)
                        ->findOneBy(['name' => $herbNew]);
                    $recipeHerb = new RecipeHerb();
                    $recipeHerb->setHerb($herb);
                    $recipeHerb->setRecipe($recipe);
                    $entityManager->persist($recipeHerb);
                }
            }
        };

        // ------------
        // UPDATE INGREDIENTS & QUANTITYS

        // search for all the ingredients that are in the database for this recipe

        $allIngredientsOld = $recipe->getIngredients();

        // first, let's compare the old ingr with the new ingr, and check wich one we need to DELETE
        foreach($allIngredientsOld as $ingredientOld){
            $todelete = TRUE;
            foreach($data["ingredients"] as $ingredientNew){
                if($ingredientNew["name"] == $ingredientOld->getIngredient()->getName()){
                    $todelete = FALSE;
                }
            }
            if($todelete === TRUE){
                $entityManager->remove($ingredientOld);
            }
        }

        // after that, let's compare the new ingr with the old ingr, and check wich one we need to ADD or CHANGE THE QUANTITY

        foreach($data["ingredients"] as $ingredientNew){
            $toadd = TRUE;
            $quantity = $ingredientNew["quantity"] / $data["numberOfEaters"];
            foreach($allIngredientsOld as $ingredientOld){
                if($ingredientNew["name"] == $ingredientOld->getIngredient()->getName()){
                    $toadd = FALSE;
                    if($ingredientOld->getQuantity() != $quantity){
                        $ingredientOld->setQuantity($quantity);
                    }
                }
            }
            if($toadd === TRUE){
                $ingr = $this->getDoctrine()
                    ->getRepository(Ingredient::class)
                    ->findOneBy(['name' => $ingredientNew]);
                
                $recipeIngredient = new RecipeIngredients();
                $recipeIngredient->setIngredient($ingr)
                    ->setRecipe($recipe)
                    ->setQuantity($quantity);
                $entityManager->persist($recipeIngredient);
            }
        }

        $response = new JsonResponse();
        $response->setData(['statuscode' => $addvalue->tryCatch($entityManager, $recipe)]);
    
        return $response;
    }

    
     /**
     * @Route("/show/recept/{slug}", name="show_recipe")
     */
    public function show($slug){
        $this->denyAccessUnlessGranted('ROLE_USER');

        $recipe = $this->getDoctrine()
            ->getRepository(Recipes::class)
            ->findOneBy(['name' => $slug]);

        if(!$recipe){
            return $this->render('general/index.html.twig');
        }else{ 
            return $this->render('recipe/individual.html.twig', [
                'value' => $recipe,
                'nrOfEaters' => 10,
                'mode' => "show",
            ]);
        }
    }


    /**
     * @Route("/show/recepten", name="show_recipes")
     */
    public function showall(){
        $this->denyAccessUnlessGranted('ROLE_USER');

        $allRecipes = $this->getDoctrine()
            ->getRepository(Recipes::class)
            ->findAll();

        dump($allRecipes);

        return $this->render('recipe/all.html.twig', [
            'values' => $allRecipes,
        ]);
    }
}
