<?php

namespace App\Controller;

use App\Entity\Rayon;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AddRecipeController extends AbstractController
{
     /**
     * @Route("/add", name="cms")
     */
    public function homepage()
    {
        return $this->render('add_recipe/index.html.twig');
    }
    
    /**
     * @Route("/add/recipe", name="add_recipe")
     */
    public function index()
    {
        return $this->render('add_recipe/addrecipe.html.twig');
    }

    /**
     * @Route("/add/ingredient", name="add_ingredient")
     */
    public function ingredient()
    {
        $rayons = $this->getDoctrine()
        ->getRepository(Rayon::class)
        ->findAll();

        return $this->render('add_recipe/addingredient.html.twig', [
            'rayons' => $rayons,
        ]);
    }
}
