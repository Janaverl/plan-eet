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
        return new JsonResponse($data);
    }
}
