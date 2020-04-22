<?php

namespace App\Controller\Api;

use App\Entity\SingleColumnName;
use App\Service\Addvalue;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SingleValueApiController extends AbstractController
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store($slug, Request $request, Addvalue $addvalue): Response
    {
        $data = json_decode($request->getContent(), true);

        // check if the slug is in the SingleColumnName-table
        $entity = $this->getDoctrine()
            ->getRepository(SingleColumnName::class)
            ->findOneBy(['name' => $slug]);

        // prepare the response
        $response = new JsonResponse();

        if (empty($entity)) {
            // message: page nog found
            // status: 404
            $response->setData(['statuscode' => 404]);
            return $response;
        }

        // create the object for the new value
        $entityTableName = "App\\Entity\\" . $entity->getTablename();
        $newValue = new $entityTableName;
        $newValue->setName($data["name"]);

        $entityManager = $this->getDoctrine()->getManager();

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($newValue);
        $response->setData(['statuscode' => $addvalue->tryCatch($entityManager)]);

        return $response;
    }
}
