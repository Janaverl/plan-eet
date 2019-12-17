<?php

namespace App\Controller;

use App\Entity\Rayon;
use App\Entity\Ingredient;
use App\Entity\SingleColumnName;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class RecipeController extends AbstractController{
    
    /**
     * @Route("/add/recipe", name="add_recipe")
     */
    public function add(){
        // $this->denyAccessUnlessGranted('ROLE_USER');

        // // or add an optional message - seen by developers
        // $this->denyAccessUnlessGranted('ROLE_USER', null, 'User tried to access a page without having ROLE_USER');

        return $this->render('recipe/add.html.twig');
    }

}
