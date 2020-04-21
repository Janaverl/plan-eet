<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Entity\Rayon;
use App\Entity\Unit;
use App\Service\Addvalue;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/ingredients")
 */
class IngredientApiController extends AbstractController
{

    /**
     * @param Request $request
     * @param Addvalue $addvalue
     * @return Response
     * @Route("/store", name="ingredients_api_store", methods={"POST"})
     */
    public function store(Request $request, Addvalue $addvalue): Response
    {
        $data = json_decode($request->getContent(), true);

        // define the entitymanager, because you will need to send data later in this API
        $entityManager = $this->getDoctrine()->getManager();

        // collect all the data needed and process it, so it can be send to the database
        $rayon = $this->getDoctrine()
            ->getRepository(Rayon::class)
            ->findOneBy(['name' => $data["rayon"]]);

        $unit = $this->getDoctrine()
            ->getRepository(Unit::class)
            ->findOneBy(['name' => $data["unit"]]);

        // create the object for the new ingredient
        $ingredient = new Ingredient();
        $ingredient->setName($data["name"])
            ->setRayon($rayon)
            ->setUnit($unit);
        
        if (!empty($data["suggestion"])) {
            $ingredient->setSuggestion($data["suggestion"]);
        };

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($ingredient);

        $response = new JsonResponse();
        $response->setData(['statuscode' => $addvalue->tryCatch($entityManager)]);

        return $response;
    }

    /**
     * @param Request $request
     * @param Addvalue $addvalue
     * @return Response
     * @Route("/update", name="ingredients_api_update", methods={"POST"})
     */
    public function update(Request $request, Addvalue $addvalue): Response
    {
        $data = json_decode($request->getContent(), true);

        if (empty($data["suggestion"])) {
            $data["suggestion"] = null;
        };

        // define the entitymanager, because you will need to send data later in this API
        $entityManager = $this->getDoctrine()->getManager();

        // look for the ingredient by name
        $ingredient = $this->getDoctrine()
            ->getRepository(Ingredient::class)
            ->findOneBy(['name' => $data["name"]]);

        // look for a single Rayon by name
        $rayon = $this->getDoctrine()
            ->getRepository(Rayon::class)
            ->findOneBy(['name' => $data["rayon"]]);

        // look for a single Unit by name
        $unit = $this->getDoctrine()
            ->getRepository(Unit::class)
            ->findOneBy(['name' => $data["unit"]]);

        $ingredient->setRayon($rayon)
            ->setUnit($unit)
            ->setSuggestion($data["suggestion"]);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($ingredient);

        $response = new JsonResponse();
        $response->setData(['statuscode' => $addvalue->tryCatch($entityManager)]);

        return $response;
    }

}
