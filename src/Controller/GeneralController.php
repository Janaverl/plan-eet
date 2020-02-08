<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class GeneralController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function index(AuthenticationUtils $authenticationUtils): Response
    {

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('general/index.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    /**
     * @Route("/guide", name="guide")
     */
    public function guide()
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        return $this->render('general/guide.html.twig');
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function admin()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('general/admin.html.twig');
    }
}
