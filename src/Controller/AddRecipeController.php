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
        return $this->render('general/index.html.twig');
    }
    
    /**
     * @Route("/add/recipe", name="add_recipe")
     */
    public function index(){
        $this->denyAccessUnlessGranted('ROLE_USER');

        // or add an optional message - seen by developers
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'User tried to access a page without having ROLE_USER');

        return $this->render('add_recipe/addrecipe.html.twig');
    }

    /**
     * @Route("/add/ingredient", name="add_ingredient")
     */
    public function ingredient(){
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // or add an optional message - seen by developers
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
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
    public function addIngredient(Request $request) : Response {
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

    /**
     * @Route("/add/{slug}", name="add_single")
     */
    public function rayon($slug){
        // $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // // or add an optional message - seen by developers
        // $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');

        if($slug != "rayon"){
            return $this->render('general/index.html.twig');
        }else{
            if($slug == "rayon"){
                $result = $this->getDoctrine()
                ->getRepository(Rayon::class)
                ->findAll();
            };
    
            dump($result);
    
            return $this->render('add_recipe/addname.html.twig', [
                'name' => "rayon",
                'slug' => $slug,
                'values' => $result,
                'jsdir' => "/js/createRayon.js",
                'API' => "\/fetch\/add\/rayon"
            ]);
        }
    
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/fetch/add/rayon", name="fetch_add_rayon", methods={"POST"})
     */
    public function addRayon(Request $request) : Response {
        $data = json_decode($request->getContent(), true);

        // $repository = $this->getDoctrine()->getRepository(Rayon::class);

        // // look for a single Rayon by name
        // $rayon = $repository->findOneBy(['name' => $data["rayon"]]);

        // make the
        $rayon = new Rayon();
        $rayon->setName($data["name"]);

        $entityManager = $this->getDoctrine()->getManager();

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($rayon);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        // return the JsonRespons if saved
        return new JsonResponse(['name' => $rayon->getName()]);
    }
}
