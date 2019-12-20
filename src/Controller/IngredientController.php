<?php

namespace App\Controller;

use App\Entity\Rayon;
use App\Entity\Ingredient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Service\Addvalue;

class IngredientController extends AbstractController{

     /**
     * @Route("/add/ingredient", name="add_ingredient")
     */
    public function add(){
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $allIngredients = $this->getDoctrine()
        ->getRepository(Ingredient::class)
        ->findAll();

        $allRayons = $this->getDoctrine()
        ->getRepository(Rayon::class)
        ->findAll();

        return $this->render('ingredient/add.html.twig', [
            'values' => $allIngredients,
            'rayons' => $allRayons,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/fetch/add/ingredient", name="fetch_add_ingredient", methods={"POST"})
     */
    public function fetch(Request $request, Addvalue $addvalue) : Response {
        $data = json_decode($request->getContent(), true);

        $repository = $this->getDoctrine()->getRepository(Rayon::class);

        // look for a single Rayon by name
        $rayon = $repository->findOneBy(['name' => $data["rayon"]]);

        // create the object for the new value
        $ingredient = new Ingredient();
        $ingredient->setName($data["name"]);
        if(isset($data["suggestion"]) && $data["suggestion"] != ""){
            $ingredient->setSuggestion($data["suggestion"]);     
        };
        $ingredient->setUnit($data["unit"]);
        $ingredient->setRayon($rayon);

        $entityManager = $this->getDoctrine()->getManager();

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($ingredient);

        $response = new JsonResponse();
        $response->setData(['statuscode' => $addvalue->tryCatch($entityManager, $ingredient)]);

        // $entityManager = $this->getDoctrine()->getManager();

        // // tell Doctrine you want to (eventually) save the Product (no queries yet)
        // $entityManager->persist($ingredient);
        //         // prepare the response
        //         $response = new JsonResponse();

        // try {
        //     // message: created
        //     // status: 201

        //     // actually executes the queries (i.e. the INSERT query)
        //     $entityManager->flush();
        //     $response->setData(['statuscode' => 201]);
        // }
        // catch (UniqueConstraintViolationException $e) {
        //     // message: Unprocessable Entity
        //     // status: 422
        //     $response->setData(['statuscode' => 422]);
        // }
        // catch (Exception $e) {
        //     // message: bad request
        //     // status: 400 
        //     $response->setData(['statuscode' => 400]);
        // }
    
        return $response;
    }
}
