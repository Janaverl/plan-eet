<?php

namespace App\Controller;

use App\Entity\Camp;
use App\Entity\Mealmoment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CampController extends AbstractController
{
    public function index($time)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $user = $this->getUser();

        $entityManager = $this->getDoctrine()->getManager();

        switch ($time) {
            case "past":
                $allCamps = $entityManager->getRepository(Camp::class)
                    ->findAllCampsByUserPast($user);
                $title = "bekijk al jouw afgelopen kampen";
                break;
            case "now":
                $allCamps = $entityManager->getRepository(Camp::class)
                    ->findAllCampsByUserPresent($user);
                $title = "bekijk al jouw kampen die nu bezig zijn";
                break;
            case "admin_all":
                $this->denyAccessUnlessGranted('ROLE_ADMIN');

                $allCamps = $entityManager->getRepository(Camp::class)
                    ->findAll();
                $title = "overzicht van alle kampen";
                break;
            default:
                $allCamps = $entityManager->getRepository(Camp::class)
                    ->findAllCampsByUserFuture($user);
                $title = "bekijk al jouw geplande kampen";
        }

        return $this->render('camp/all.html.twig', [
            'values' => $allCamps,
            'title' => $title,
        ]);
    }

    public function show(Camp $camp)
    {
        if (empty($camp)) {
            return $this->redirectToRoute(
                'camps_index',
                ['time' => "future"]
            );
        };

        $this->denyAccessUnlessGranted('view', $camp);

        return $this->render(
            'camp/callenderindividual.html.twig',
            [
                'value' => $camp
            ]
        );
    }

    public function create()
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        // get all mealmoments, so the user can select them and add them to the camp he is creating
        $allMealmoments = $this->getDoctrine()
            ->getRepository(Mealmoment::class)
            ->findAll();

        return $this->render(
            'camp/individual.html.twig',
            ['mealmoments' => $allMealmoments]
        );
    }

}
