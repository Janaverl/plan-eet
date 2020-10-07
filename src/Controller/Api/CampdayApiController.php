<?php

namespace App\Controller\Api;


use App\Entity\Camp;
use App\Entity\Campday;
use Symfony\Component\HttpFoundation\JsonResponse;

class CampdayApiController extends ApiController
{
    public function show_for_camp(Camp $camp)
    {
        $this->throwExceptionIfNotExcists($camp);
        $this->denyAccessUnlessGranted('view', $camp);

        $entityManager = $this->getDoctrine()->getManager();

        $allCampDates = $entityManager->getRepository(Campday::class)
            ->findDatesByCamp($camp);

        return new JsonResponse($allCampDates);
    }
}