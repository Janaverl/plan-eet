<?php

namespace App\Controller\Api;

use App\Entity\RecipeCategory;
use App\Entity\Recipes;
use App\Entity\RecipeType;
use App\Service\Addvalue;
use App\Service\RecipeServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RecipeApiController extends AbstractController
{
    /**
     * @param Request $request
     * @param Addvalue $addvalue
     * @return Response
     */
    public function store(Request $request, Addvalue $addvalue, RecipeServices $recipeServices): Response
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
     * @param Request $request
     * @param Addvalue $addvalue
     * @return Response
     */
    public function update(Request $request, Addvalue $addvalue, RecipeServices $recipeServices): Response
    {
        $data = json_decode($request->getContent(), true);

        if (empty($data["suggestion"])) {
            $data["suggestion"] = null;
        }

        if (empty($data["herbs"])) {
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

}
