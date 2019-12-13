<?php

namespace App\Controller;

use App\Entity\Rayon;
use App\Entity\Ingredient;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class AddRecipeController extends AbstractController{
    /**
     * @Route("/add", name="cms")
     */
    public function homepage(){
        return $this->render('add_recipe/index.html.twig');
    }
    
    /**
     * @Route("/add/recipe", name="add_recipe")
     */
    public function index(){
        return $this->render('add_recipe/addrecipe.html.twig');
    }

    /**
     * @Route("/add/ingredient", name="add_ingredient")
     */
    public function ingredient(){
        $result = $this->getDoctrine()
        ->getRepository(Rayon::class)
        ->findAll();

        dump($result);

        return $this->render('add_recipe/addingredient.html.twig', [
            'rayons' => $result,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/fetch/add/ingredient", name="fetch_add_ingredient", methods={"POST"})
     */
    public function show(Request $request){
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

        // return new Response('Saved new product with id '.$product->getId());
        return new JsonResponse('success saving ::: '.$ingredient->getName());
    }
}
