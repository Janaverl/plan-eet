<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AddRecipeController extends AbstractController
{
     /**
     * @Route("/", name="app_homepage")
     */
    public function homepage()
    {
        return $this->render('add_recipe/homepage.html.twig');
    }
    
    /**
     * @Route("/add/recipe", name="add_recipe")
     */
    public function index()
    {
        return $this->render('add_recipe/addrecipe.html.twig');
    }
}
