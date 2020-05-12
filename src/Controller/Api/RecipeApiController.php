<?php

namespace App\Controller\Api;

use App\Entity\Herb;
use App\Entity\Ingredient;
use App\Entity\RecipeCategory;
use App\Entity\RecipeHerb;
use App\Entity\RecipeIngredients;
use App\Entity\Recipes;
use App\Entity\RecipeType;
use App\Service\Addvalue;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RecipeApiController extends ApiController
{
    /**
     * @param array $data
     * @param object $recipe
     * @param object $entityManager
     * @return void
     */
    protected function process_recipe_data(array $data, object $recipe, object $entityManager) : void
    {
        if (empty($data["category"]) || empty($data["type"])) {
            $this->throwExceptionBecauseIsEmpty();
        }

        $category = $entityManager->getRepository(RecipeCategory::class)
            ->findOneBy(['name' => $data["category"]]);

        $type = $entityManager->getRepository(RecipeType::class)
            ->findOneBy(['name' => $data["type"]]);

        $suggestion = (empty($data["suggestion"])) ? null : $data["suggestion"];

        $recipe->setInstructions($data["instructions"])
            ->setCategory($category)
            ->setType($type)
            ->setSuggestion($suggestion);

        $entityManager->persist($recipe);
    }

    /**
     * @param object $recipe
     * @param object $entityManager
     * @param array $herbs
     * @return void
     */
    protected function create_herbs(object $recipe, object $entityManager, array $herbs = []): void
    {
        foreach ($herbs as $herb) {
            $herb = $this->getDoctrine()
                ->getRepository(Herb::class)
                ->findOneBy(['name' => $herb]);

            $recipeHerb = new RecipeHerb();
            $recipeHerb->setHerb($herb);
            $recipeHerb->setRecipe($recipe);
            $entityManager->persist($recipeHerb);
        }
    }

    /**
     * @param integer $numberOfEaters
     * @param object $recipe
     * @param object $entityManager
     * @param array $ingredients
     * @return void
     */
    protected function create_ingredients(int $numberOfEaters, object $recipe, object $entityManager, array $ingredients = []): void
    {
        foreach ($ingredients as $ingredient) {
            $quantity = $ingredient["quantity"] / $numberOfEaters;

            $ingr = $this->getDoctrine()
                ->getRepository(Ingredient::class)
                ->findOneBy(['name' => $ingredient["name"]]);

            $recipeIngredient = new RecipeIngredients();
            $recipeIngredient->setIngredient($ingr)
                ->setRecipe($recipe)
                ->setQuantity($quantity);

            $entityManager->persist($recipeIngredient);
        }
    }

    /**
     * @param object $recipe
     * @param array $newherbs
     * @param object $entityManager
     * @return void
     */
    protected function check_and_update_herbs(object $recipe, array $newherbs, object $entityManager): void
    {
        // search for all the herbs that are in the database for this recipe
        $oldHerbs = $recipe->getRecipeHerb();

        // first, let's compare the old herbs with the new herbs, and check wich one we need to DELETE
        foreach ($oldHerbs as $oldHerb) {
            foreach ($newherbs as $newHerb) {
                if ($newHerb == $oldHerb->getHerb()->getName()) {
                    continue 2;
                }
            }
            
            $entityManager->remove($oldHerb);
        }

        // after that, let's compare the new herbs with the old herbs, and check wich one we need to ADD
        foreach ($newherbs as $herbNew) {
            foreach ($oldHerbs as $oldHerb) {
                if ($herbNew == $oldHerb->getHerb()->getName()) {
                    continue 2;
                }
            }

            // look for a single herb by name
            $herb = $this->getDoctrine()
                ->getRepository(Herb::class)
                ->findOneBy(['name' => $herbNew]);

            $recipeHerb = new RecipeHerb();
            $recipeHerb->setHerb($herb)
                ->setRecipe($recipe);

            $entityManager->persist($recipeHerb);
        }

    }

    /**
     * @param object $recipe
     * @param array $newIngredients
     * @param integer $numberOfEaters
     * @param object $entityManager
     * @return void
     */
    protected function check_and_update_ingredients(object $recipe, array $newIngredients, int $numberOfEaters, object $entityManager): void
    {
        // search for all the ingredients that are in the database for this recipe
        $oldIngredients = $recipe->getIngredients();

        // first, let's compare the old ingr with the new ingr, and check wich one we need to DELETE
        foreach ($oldIngredients as $oldIngredient) {
            foreach ($newIngredients as $newIngredient) {
                if ($newIngredient["name"] == $oldIngredient->getIngredient()->getName()) {
                    continue 2;
                }
            }

            $entityManager->remove($oldIngredient);
        }

        // after that, let's compare the new ingr with the old ingr, and check wich one we need to ADD or CHANGE THE QUANTITY
        foreach ($newIngredients as $newIngredient) {

            $quantity = $newIngredient["quantity"] / $numberOfEaters;

            foreach ($oldIngredients as $oldIngredient) {
                if ($newIngredient["name"] == $oldIngredient->getIngredient()->getName()) {
                    if ($oldIngredient->getQuantity() != $quantity) {
                        $oldIngredient->setQuantity($quantity);
                    }
                    continue 2;
                }
            }
            $ingr = $this->getDoctrine()
                ->getRepository(Ingredient::class)
                ->findOneBy(['name' => $newIngredient]);

            $recipeIngredient = new RecipeIngredients();
            $recipeIngredient->setIngredient($ingr)
                ->setRecipe($recipe)
                ->setQuantity($quantity);
                
            $entityManager->persist($recipeIngredient);
        }
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function store(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $data = json_decode($request->getContent(), true);
        $entityManager = $this->getDoctrine()->getManager();

        // BASICS RECIPE
        $recipe = new Recipes();
        $recipe->setName($data["name"]); 
        $this->process_recipe_data($data, $recipe, $entityManager);

        // HERBS THAT BELONG TO THE RECIPE
        if (!empty($data["herbs"])) {
            $this->create_herbs($recipe, $entityManager, $data["herbs"]);
        };

        // INGREDIENTS THAT BELONG TO THE RECIPE
        $this->create_ingredients($data["numberOfEaters"], $recipe, $entityManager, $data["ingredients"]);

        // FINISH THE REQUEST
        $this->flushOrThrowException($entityManager);

        $response = new JsonResponse("success");

        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function update(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $data = json_decode($request->getContent(), true);
        $entityManager = $this->getDoctrine()->getManager();

        // BASICS RECIPE
        $recipe = $entityManager->getRepository(Recipes::class)
            ->findOneBy(['name' => $data["name"]]);
        $this->process_recipe_data($data, $recipe, $entityManager);

        // HERBS THAT BELONG TO THE RECIPE
        if (empty($data["herbs"])) {
            $data["herbs"] = [];
        }
        $this->check_and_update_herbs($recipe, $data["herbs"], $entityManager);

        // INGREDIENTS THAT BELONG TO THE RECIPE
        $this->check_and_update_ingredients($recipe, $data["ingredients"], $data["numberOfEaters"], $entityManager);

        // FINISH THE REQUEST
        $this->flushOrThrowException($entityManager);

        $response = new JsonResponse("success");

        return $response;
    }

     /**
     * @param Request $request
     * @return Response
     */
    public function delete(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $data = json_decode($request->getContent(), true);

        $entityManager = $this->getDoctrine()->getManager();

        $recipe = $entityManager->getRepository(Recipes::class)
            ->findOneBy(['name' => $data["name"]]);

        $entityManager->remove($recipe);

        $this->flushOrThrowException($entityManager);

        $response = new JsonResponse("success");

        return $response;
    }

}
