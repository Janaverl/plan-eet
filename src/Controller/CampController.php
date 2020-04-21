<?php

namespace App\Controller;

use App\Entity\Camp;
use App\Entity\Mealmoment;
use App\Service\ValidateRoute;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/camps")
 */
class CampController extends AbstractController
{
    /**
     * @Route("/index/{slug}", name="camps_index")
     */
    public function index($slug)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $user = $this->getUser();

        $entityManager = $this->getDoctrine()->getManager();

        switch ($slug) {
            case "past":
                $allCamps = $entityManager->getRepository('App:Camp')
                    ->findAllCampsByUserPast($user);
                $title = "bekijk al jouw afgelopen kampen";
                break;
            case "now":
                $allCamps = $entityManager->getRepository('App:Camp')
                    ->findAllCampsByUserPresent($user);
                $title = "bekijk al jouw kampen die nu bezig zijn";
                break;
            case "admin_all":
                $this->denyAccessUnlessGranted('ROLE_ADMIN');

                $allCamps = $entityManager->getRepository('App:Camp')
                    ->findAll();
                $title = "overzicht van alle kampen";
                break;
            default:
                $allCamps = $entityManager->getRepository('App:Camp')
                    ->findAllCampsByUserFuture($user);
                $title = "bekijk al jouw geplande kampen";
        }

        return $this->render('camp/all.html.twig', [
            'values' => $allCamps,
            'title' => $title,
        ]);
    }

    /**
     * @Route("/show/{slug}", name="camps_show")
     */
    public function show($slug, ValidateRoute $validateRoute)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $camp = $this->getDoctrine()
            ->getRepository(Camp::class)
            ->findOneBy(['id' => $_GET["camp"]]);

        if (!empty($camp)) {        
            $isCreatedByUser = $validateRoute->isCreatedByUser($this->getUser(), $camp->getUser());
            $hasMatchingSlug = $validateRoute->hasMatchingSlug($slug, $camp->getName());
        }

        if (empty($camp) or !$isCreatedByUser or !$hasMatchingSlug) {
            return $this->redirectToRoute('camps_index', [
                'slug' => "future"
            ]);
        };

        return $this->render('camp/callenderindividual.html.twig', [
            'value' => $camp
        ]);
    }

    /**
     * @Route("/create", name="camps_create")
     */
    public function create()
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        // get all mealmoments, so the user can select them and add them to the camp he is creating
        $allMealmoments = $this->getDoctrine()
            ->getRepository(Mealmoment::class)
            ->findAll();

        return $this->render('camp/individual.html.twig', [
            'mealmoments' => $allMealmoments
        ]);
    }

}
