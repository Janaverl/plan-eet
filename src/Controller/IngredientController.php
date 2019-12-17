<?php

namespace App\Controller;

use App\Entity\Rayon;
use App\Entity\Ingredient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class IngredientController extends AbstractController{

     /**
     * @Route("/add/ingredient", name="add_ingredient")
     */
    public function add(){
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // or add an optional message - seen by developers
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        $result = $this->getDoctrine()
        ->getRepository(Rayon::class)
        ->findAll();

        dump($result);

        return $this->render('ingredient/add.html.twig', [
            'rayons' => $result,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/fetch/add/ingredient", name="fetch_add_ingredient", methods={"POST"})
     */
    public function fetch(Request $request) : Response {
        $data = json_decode($request->getContent(), true);

        $repository = $this->getDoctrine()->getRepository(Rayon::class);

        // look for a single Rayon by name
        $rayon = $repository->findOneBy(['name' => $data["rayon"]]);

        // make the
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

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        // return the JsonRespons if saved
        return new JsonResponse(['ingredient' => $ingredient->getName()]);
    }
}
