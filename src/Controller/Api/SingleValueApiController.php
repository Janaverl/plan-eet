<?php

namespace App\Controller\Api;

use App\Entity\SingleColumnName;
use App\Service\Addvalue;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SingleValueApiController extends ApiController
{
    /**
     * @param string $entityname
     * @param Request $request
     * @return Response
     */
    public function store(string $entityname, Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        $data = json_decode($request->getContent(), true);

        // check if the slug is in the SingleColumnName-table
        $entity = $this->getDoctrine()
            ->getRepository(SingleColumnName::class)
            ->findOneBy(['name' => $entityname]);
        
        $this->throwExceptionIfNotExcists($entity);

        $entityTableName = "App\\Entity\\" . $entity->getTablename();

        if (empty($data["name"])) {
            $this->throwExceptionBecauseIsEmpty();
        }

        $newValue = new $entityTableName;
        $newValue->setName($data["name"]);

        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->persist($newValue);

        $this->flushOrThrowException($entityManager);

        $response = new JsonResponse("success");

        return $response;
    }
}
