<?php

namespace App\Service;

use App\Entity\Herb;
use App\Entity\Ingredient;
use App\Entity\RecipeHerb;
use App\Entity\RecipeIngredients;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RecipeServices extends AbstractController
{
    /**
     * @param array $herbs
     * @param object $recipe
     * @param object $entityManager
     * @return void
     */
    public function create_herbs(array $herbs = [], object $recipe, object $entityManager): void
    {
        foreach ($herbs as $herb) {
            // look for a single herb by name
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
     * @param array $ingredients
     * @param integer $numberOfEaters
     * @param object $recipe
     * @param object $entityManager
     * @return void
     */
    public function create_ingredients(array $ingredients = [], int $numberOfEaters, object $recipe, object $entityManager): void
    {
        foreach ($ingredients as $ingredient) {
            $quantity = $ingredient["quantity"] / $numberOfEaters;

            // look for a single ingredient by name
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
     * @param string $newValue
     * @param string $oldValue
     * @return boolean
     */
    public function is_this_string_changed(string $newValue, string $oldValue): bool
    {
        if ($newValue === $oldValue) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @param object $recipe
     * @param array $newherbs
     * @param object $entityManager
     * @return void
     */
    public function check_and_update_herbs(object $recipe, array $newherbs, object $entityManager): void
    {
        // search for all the herbs that are in the database for this recipe
        $oldHerbs = $recipe->getRecipeHerb();

        // first, let's compare the old herbs with the new herbs, and check wich one we need to DELETE
        foreach ($oldHerbs as $oldHerb) {
            $todelete = true;
            foreach ($newherbs as $herbNew) {
                if ($herbNew == $oldHerb->getHerb()->getName()) {
                    $todelete = false;
                }
            }
            if ($todelete === true) {
                $entityManager->remove($oldHerb);
            }
        }

        // after that, let's compare the new herbs with the old herbs, and check wich one we need to ADD
        foreach ($newherbs as $herbNew) {
            $toadd = true;
            foreach ($oldHerbs as $oldHerb) {
                if ($herbNew == $oldHerb->getHerb()->getName()) {
                    $toadd = false;
                }
            }
            if ($toadd === true) {
                // look for a single herb by name
                $herb = $this->getDoctrine()
                    ->getRepository(Herb::class)
                    ->findOneBy(['name' => $herbNew]);

                $recipeHerb = new RecipeHerb();
                $recipeHerb->setHerb($herb)
                    ->setRecipe($recipe);

                $entityManager->persist($recipeHerb);
            }
        };
    }

    /**
     * @param object $recipe
     * @param array $newIngredients
     * @param integer $numberOfEaters
     * @param object $entityManager
     * @return void
     */
    public function check_and_update_ingredients(object $recipe, array $newIngredients, int $numberOfEaters, object $entityManager): void
    {
        // search for all the ingredients that are in the database for this recipe
        $oldIngredients = $recipe->getIngredients();

        // first, let's compare the old ingr with the new ingr, and check wich one we need to DELETE
        foreach ($oldIngredients as $oldIngredient) {
            $todelete = true;
            foreach ($newIngredients as $newIngredient) {
                if ($newIngredient["name"] == $oldIngredient->getIngredient()->getName()) {
                    $todelete = false;
                }
            }
            if ($todelete === true) {
                $entityManager->remove($oldIngredient);
            }
        }

        // after that, let's compare the new ingr with the old ingr, and check wich one we need to ADD or CHANGE THE QUANTITY
        foreach ($newIngredients as $newIngredient) {
            $toadd = true;
            $quantity = $newIngredient["quantity"] / $numberOfEaters;
            foreach ($oldIngredients as $oldIngredient) {
                if ($newIngredient["name"] == $oldIngredient->getIngredient()->getName()) {
                    $toadd = false;
                    if ($oldIngredient->getQuantity() != $quantity) {
                        $oldIngredient->setQuantity($quantity);
                    }
                }
            }
            if ($toadd === true) {
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
    }
}
