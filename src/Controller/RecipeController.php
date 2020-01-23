<?php

namespace App\Controller;

use App\Entity\Herb;
use App\Entity\Ingredient;
use App\Entity\RecipeCategory;
use App\Entity\Recipes;
use App\Entity\RecipeType;
use App\Service\Addvalue;
use App\Service\RecipeServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecipeController extends AbstractController
{

    /**
     * @Route("/add/recipe", name="add_recipe")
     */
    public function add()
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
     * @param Request $request
     * @param Addvalue $addvalue
     * @return Response
     * @Route("/fetch/add/recipe", name="fetch_add_recipe", methods={"POST"})
     */
    public function addAction(Request $request, Addvalue $addvalue, RecipeServices $recipeServices): Response
    {
        $data = json_decode($request->getContent(), true);

        // define the entitymanager, because you will need to send data later in this API
        $entityManager = $this->getDoctrine()->getManager();

        // collect all the data needed and process it, so it can be send to the database
        $category = $this->getDoctrine()
            ->getRepository(RecipeCategory::class)
            ->findOneBy(['name' => $data["category"]]);

        $type = $this->getDoctrine()
            ->getRepository(RecipeType::class)
            ->findOneBy(['name' => $data["type"]]);

        // create the object for the new recipe
        $recipe = new Recipes();
        $recipe->setName($data["name"])
            ->setInstructions($data["instructions"])
            ->setCategory($category)
            ->setType($type);
        if (isset($data["suggestion"]) && $data["suggestion"] != "") {
            $recipe->setSuggestion($data["suggestion"]);
        };

        // tell Doctrine you want to (eventually) save the recipe (no queries yet)
        $entityManager->persist($recipe);

        // create the object(s) for the herbs of the recipe
        if (isset($data["herbs"])) {
            $recipeServices->create_herbs($data["herbs"], $recipe, $entityManager);
        };

        // create the object(s) for the ingredients of the recipe
        $recipeServices->create_ingredients($data["ingredients"], $data["numberOfEaters"], $recipe, $entityManager);

        $response = new JsonResponse();
        $response->setData(['statuscode' => $addvalue->tryCatch($entityManager)]);

        return $response;
    }

    /**
     * @Route("/update/recept/{slug}", name="update_recipe")
     */
    public function update($slug)
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

            return $this->render('general/index.html.twig');

        }
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/fetch/update/recipe", name="fetch_update_recipe", methods={"POST"})
     */
    public function updateAction(Request $request, Addvalue $addvalue, RecipeServices $recipeServices): Response
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data["suggestion"])) {
            $data["suggestion"] = "";
        };
        if (!isset($data["herbs"])) {
            $data["herbs"] = [];
        }

        // define the entitymanager, because you will need to send data later in this API
        $entityManager = $this->getDoctrine()->getManager();

        // look for the recipe by name
        $recipe = $this->getDoctrine()
            ->getRepository(Recipes::class)
            ->findOneBy(['name' => $data["name"]]);

        // check if the strings are changed
        $categoryChanged = $recipeServices->is_this_string_changed($data["category"], $recipe->getCategory()->getName());
        $typeChanged = $recipeServices->is_this_string_changed($data["type"], $recipe->getType()->getName());
        $instructionChanged = $recipeServices->is_this_string_changed($data["instructions"], $recipe->getInstructions());
        $suggestionChanged = $recipeServices->is_this_string_changed($data["suggestion"], $recipe->getSuggestion());

        // change the old values if needed
        if ($categoryChanged) {
            $category = $this->getDoctrine()
                ->getRepository(RecipeCategory::class)
                ->findOneBy(['name' => $data["category"]]);

            $recipe->setCategory($category);
        };

        if ($typeChanged) {
            $type = $this->getDoctrine()
                ->getRepository(RecipeType::class)
                ->findOneBy(['name' => $data["type"]]);

            $recipe->setType($type);
        };

        if ($instructionChanged) {
            $recipe->setInstructions($data["instructions"]);
        }

        if ($suggestionChanged) {
            $recipe->setSuggestion($data["suggestion"]);
        }

        $recipeServices->check_and_update_herbs($recipe, $data["herbs"], $entityManager);
        $recipeServices->check_and_update_ingredients($recipe, $data["ingredients"], $data["numberOfEaters"], $entityManager);

        $response = new JsonResponse();
        $response->setData(['statuscode' => $addvalue->tryCatch($entityManager)]);

        return $response;
    }

    /**
     * @Route("/show/recept/{slug}", name="show_recipe")
     */
    public function show($slug)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $recipe = $this->getDoctrine()
            ->getRepository(Recipes::class)
            ->findOneBy(['name' => $slug]);

        if (isset($recipe)) {
            $pageCanLoad = true;
        } else {
            $pageCanLoad = false;
        };

        if ($pageCanLoad) {
            $ingredients = $entityManager->getRepository('App:RecipeIngredients')
                ->findIngredientsSortedByRayon($recipe);

            return $this->render('recipe/individual.html.twig', [
                'value' => $recipe,
                'ingredients' => $ingredients,
                'nrOfEaters' => 10,
                'mode' => "show",
            ]);
        } else {

            return $this->render('general/index.html.twig');

        }
    }

    /**
     * @Route("/show/recepten", name="show_recipes")
     */
    public function showall()
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
}
