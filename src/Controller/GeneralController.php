<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GeneralController extends AbstractController
{
     /**
     * @Route("/", name="app_homepage")
     */
    public function index()
    {
        return $this->render('general/index.html.twig');
    }
}
