<?php

namespace App\Controller\Api;


use App\Entity\Camp;
use App\Entity\Rayon;
use Symfony\Component\HttpFoundation\JsonResponse;

class RayonApiController extends ApiController
{
    public function show_for_camp(Camp $camp)
    {
        $this->throwExceptionIfNotExcists($camp);
        $this->denyAccessUnlessGranted('view', $camp);

        $entityManager = $this->getDoctrine()->getManager();

        $allCampRayons = $entityManager->getRepository(Rayon::class)
            ->findByCamp($camp);

        return new JsonResponse($allCampRayons);
    }
}