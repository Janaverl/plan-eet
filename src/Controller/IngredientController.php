<?php

namespace App\Controller;

use App\Entity\Rayon;
use App\Entity\Unit;
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

        $allUnits = $this->getDoctrine()
            ->getRepository(Unit::class)
            ->findAll();

        $allRayons = $this->getDoctrine()
            ->getRepository(Rayon::class)
            ->findAll();

        return $this->render('ingredient/add.html.twig', [
            'values' => $allIngredients,
            'rayons' => $allRayons,
            'units' => $allUnits,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/fetch/add/ingredient", name="fetch_add_ingredient", methods={"POST"})
     */
    public function addAction(Request $request, Addvalue $addvalue) : Response {
        $data = json_decode($request->getContent(), true);

        // look for a single Rayon by name
        $rayon = $this->getDoctrine()
            ->getRepository(Rayon::class)
            ->findOneBy(['name' => $data["rayon"]]);

        // look for a single Unit by name
        $unit = $this->getDoctrine()
            ->getRepository(Unit::class)
            ->findOneBy(['name' => $data["unit"]]);

        // create the object for the new value
        $ingredient = new Ingredient();
        $ingredient->setName($data["name"])
            ->setRayon($rayon)
            ->setUnit($unit);
        if(isset($data["suggestion"]) && $data["suggestion"] != ""){
            $ingredient->setSuggestion($data["suggestion"]);
        };

        $entityManager = $this->getDoctrine()->getManager();
        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($ingredient);

        $response = new JsonResponse();
        $response->setData(['statuscode' => $addvalue->tryCatch($entityManager, $ingredient)]);
    
        return $response;
    }
    /**
     * @Route("/show/ingredient", name="show_ingredients")
     */
    public function show(){
        $this->denyAccessUnlessGranted('ROLE_USER');

        $allIngredients = $this->getDoctrine()
            ->getRepository(Ingredient::class)
            ->findAll();

        foreach ($allIngredients as $ingredient) {
            $ingredient->getRayon()->getName();
            $ingredient->getUnit()->getName();
        };

        return $this->render('ingredient/show.html.twig', [
            'values' => $allIngredients,
        ]);
    }

     /**
     * @Route("/update/ingredient/{slug}", name="update_ingredient")
     */
    public function update($slug){
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $ingredient = $this->getDoctrine()
            ->getRepository(Ingredient::class)
            ->findOneBy(['name' => $slug]);

        if(!$ingredient){
            return $this->render('general/index.html.twig');
        }else{
            $ingredient->getRayon()->getName();

            $allRayons = $this->getDoctrine()
                ->getRepository(Rayon::class)
                ->findAll();

            $allUnits = $this->getDoctrine()
                ->getRepository(Unit::class)
                ->findAll();
    
            return $this->render('ingredient/update.html.twig', [
                'value' => $ingredient,
                'rayons' => $allRayons,
                'units' => $allUnits
            ]);
        }
    }

     /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/fetch/update/ingredient", name="fetch_update_ingredient", methods={"POST"})
     */
    public function updateAction(Request $request, Addvalue $addvalue): Response{
        $data = json_decode($request->getContent(), true);

        // look for a single Rayon by name
        $rayon = $this->getDoctrine()
            ->getRepository(Rayon::class)
            ->findOneBy(['name' => $data["rayon"]]);

        // look for a single Unit by name
        $unit = $this->getDoctrine()
            ->getRepository(Unit::class)
            ->findOneBy(['name' => $data["unit"]]);

        // look for the ingredient by name
        $ingredient = $this->getDoctrine()
            ->getRepository(Ingredient::class)
            ->findOneBy(['name' => $data["name"]]);
        
        $ingredient->setRayon($rayon)
            ->setUnit($unit);
        if(isset($data["suggestion"]) && $data["suggestion"] != ""){
            $ingredient->setSuggestion($data["suggestion"]);
        }else{
            $ingredient->setSuggestion("");
        };

        $entityManager = $this->getDoctrine()->getManager();
        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($ingredient);

        $response = new JsonResponse();
        $response->setData(['statuscode' => $addvalue->tryCatch($entityManager, $ingredient)]);
    
        return $response;
    }
}
