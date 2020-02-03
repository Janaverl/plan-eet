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

class IngredientController extends AbstractController
{

    /**
     * @Route("/add/ingredient", name="add_ingredient")
     */
    public function add()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $allIngredients = $this->getDoctrine()
            ->getRepository(Ingredient::class)
            ->findAll();

        $allUnits = $this->getDoctrine()
            ->getRepository(Unit::class)
            ->findAll();

        $allRayons = $this->getDoctrine()
            ->getRepository(Rayon::class)
            ->findAll();

        return $this->render('ingredient/individual.html.twig', [
            'values' => $allIngredients,
            'rayons' => $allRayons,
            'units' => $allUnits,
            'mode' => "add",
        ]);
    }

    /**
     * @param Request $request
     * @param Addvalue $addvalue
     * @return Response
     * @Route("/fetch/add/ingredient", name="fetch_add_ingredient", methods={"POST"})
     */
    public function addAction(Request $request, Addvalue $addvalue): Response
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
        if (isset($data["suggestion"]) && $data["suggestion"] != "") {
            $ingredient->setSuggestion($data["suggestion"]);
        };

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($ingredient);

        $response = new JsonResponse();
        $response->setData(['statuscode' => $addvalue->tryCatch($entityManager)]);

        return $response;
    }

    /**
     * @Route("/update/ingredient/{slug}", name="update_ingredient")
     */
    public function update($slug)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $ingredient = $this->getDoctrine()
            ->getRepository(Ingredient::class)
            ->findOneBy(['name' => $slug]);

        if (isset($ingredient)) {
            $pageCanLoad = true;
        } else {
            $pageCanLoad = false;
        };

        if ($pageCanLoad) {
            $allRayons = $this->getDoctrine()
                ->getRepository(Rayon::class)
                ->findAll();

            $allUnits = $this->getDoctrine()
                ->getRepository(Unit::class)
                ->findAll();

            return $this->render('ingredient/individual.html.twig', [
                'value' => $ingredient,
                'rayons' => $allRayons,
                'units' => $allUnits,
                'mode' => "update",
            ]);
        } else {

            return $this->render('general/index.html.twig');

        }
    }

    /**
     * @param Request $request
     * @param Addvalue $addvalue
     * @return Response
     * @Route("/fetch/update/ingredient", name="fetch_update_ingredient", methods={"POST"})
     */
    public function updateAction(Request $request, Addvalue $addvalue): Response
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data["suggestion"])) {
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

    /**
     * @Route("/show/ingredienten", name="show_ingredients")
     */
    public function showall()
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $allIngredients = $this->getDoctrine()
            ->getRepository(Ingredient::class)
            ->findAll();

        return $this->render('ingredient/all.html.twig', [
            'values' => $allIngredients,
        ]);
    }

    /**
     * @Route("/show/ingredienten/{slug}", name="show_ingredients_camp")
     */
    public function showallforcamp($slug)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $entityManager = $this->getDoctrine()->getManager();

        $allIngredients = $entityManager->getRepository('App:Ingredient')
            ->findArrayByCamp($slug);

        return $this->render('ingredient/shoppinglist.html.twig', [
            'ingredients' => $allIngredients,
        ]);
    }

}
