<?php

namespace App\Controller;

use App\Entity\SingleColumnName;
use App\Service\Addvalue;
use App\Service\ValidateRoute;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SingleColumnController extends AbstractController
{
    /**
     * @Route("/add/{slug}", name="add_single")
     */
    public function add($slug, ValidateRoute $validateRoute)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // check if the slug is in the SingleColumnName-table
        $entity = $this->getDoctrine()
            ->getRepository(SingleColumnName::class)
            ->findOneBy(['name' => $slug]);

        if (isset($entity)) {
            $pageCanLoad = true;
        } else {
            $pageCanLoad = false;
        };

        if ($pageCanLoad) {
            $repositoryPathForClass = "App\\Entity\\" . $entity->getTablename();

            $result = $this->getDoctrine()
                ->getRepository($repositoryPathForClass)
                ->findAll();

            return $this->render('single_column/add.html.twig', [
                'name' => $entity->getTranslation(),
                'slug' => $slug,
                'values' => $result,
                'API' => $entity->getAPI(),
            ]);

        } else {

            return $this->render('general/index.html.twig');

        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/fetch/add/{slug}", name="fetch_add_{slug}", methods={"POST"})
     */
    public function fetch(Request $request, $slug, Addvalue $addvalue): Response
    {
        $data = json_decode($request->getContent(), true);

        // check if the slug is in the SingleColumnName-table
        $entity = $this->getDoctrine()
            ->getRepository(SingleColumnName::class)
            ->findOneBy(['name' => $slug]);

        // prepare the response
        $response = new JsonResponse();

        if (!$entity) {
            // message: page nog found
            // status: 404
            $response->setData(['statuscode' => 404]);
        } else {
            // create the object for the new value
            $entityTableName = "App\\Entity\\" . $entity->getTablename();
            $newValue = new $entityTableName;
            $newValue->setName($data["name"]);

            $entityManager = $this->getDoctrine()->getManager();

            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $entityManager->persist($newValue);
            $response->setData(['statuscode' => $addvalue->tryCatch($entityManager)]);

        }
        return $response;
    }
}
