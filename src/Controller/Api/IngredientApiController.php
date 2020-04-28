<?php

namespace App\Controller\Api;

use App\Entity\Ingredient;
use App\Entity\Rayon;
use App\Entity\Unit;
use App\Service\Addvalue;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IngredientApiController extends ApiController
{
    /**
     * @param array $data
     * @param object $ingredient
     * @param object $entityManager
     * @return void
     */
    protected function process_ingredient_data(array $data, object $ingredient, object $entityManager) : void
    {
        if (empty($data["rayon"]) || empty($data["unit"])) {
            $this->throwExceptionBecauseIsEmpty();
        }

        $rayon = $entityManager->getRepository(Rayon::class)
            ->findOneBy(['name' => $data["rayon"]]);

        $unit = $entityManager->getRepository(Unit::class)
            ->findOneBy(['name' => $data["unit"]]);
        
        $suggestion = (empty($data["suggestion"])) ? null : $data["suggestion"];

        $ingredient->setRayon($rayon)
            ->setUnit($unit)
            ->setSuggestion($suggestion);

        $entityManager->persist($ingredient);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function store(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $data = json_decode($request->getContent(), true);

        $entityManager = $this->getDoctrine()->getManager();

        $ingredient = new Ingredient();
        $ingredient->setName($data["name"]);

        $this->process_ingredient_data($data, $ingredient, $entityManager);

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

        $ingredient = $entityManager->getRepository(Ingredient::class)
            ->findOneBy(['name' => $data["name"]]);

        $this->process_ingredient_data($data, $ingredient, $entityManager);

        $this->flushOrThrowException($entityManager);

        $response = new JsonResponse("success");

        return $response;
    }

}
