<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class PageController extends AbstractController
{
    public function index(AuthenticationUtils $authenticationUtils): Response
    {

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('page/index.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    public function guide()
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        return $this->render('page/guide.html.twig');
    }

    public function admin()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('page/admin.html.twig');
    }
}
