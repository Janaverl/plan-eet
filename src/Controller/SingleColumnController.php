<?php

namespace App\Controller;

use App\Entity\SingleColumnName;
use App\Entity\Rayon;
use App\Entity\RecipeCategory;
use App\Entity\RecipeType;
use App\Entity\Unit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Service\Addvalue;

class SingleColumnController extends AbstractController{
    /**
     * @Route("/add/name/{slug}", name="add_single")
     */
    public function add($slug){
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // check if the slug is in the SingleColumnName-table

        $entity = $this->getDoctrine()
            ->getRepository(SingleColumnName::class)
            ->findOneBy(['name' => $slug]);

        if(!$entity){
            return $this->render('general/index.html.twig');
        }else{
            $table = "App\\Entity\\".$entity->getTablename();

            $result = $this->getDoctrine()
            ->getRepository($table)
            ->findAll();
    
            dump($result);
    
            return $this->render('single_column/add.html.twig', [
                'name' => $entity->getTranslation(),
                'slug' => $slug,
                'values' => $result,
                'API' => $entity->getAPI(),
                // 'message' => $message,
            ]);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/fetch/add/{slug}", name="fetch_add_{slug}", methods={"POST"})
     */
    public function fetch(Request $request, $slug, Addvalue $addvalue) : Response {
        $data = json_decode($request->getContent(), true);

        // check if the slug is in the SingleColumnName-table
        $repository = $this->getDoctrine()->getRepository(SingleColumnName::class);
        $entity = $repository->findOneBy(['name' => $slug]);

        // prepare the response
        $response = new JsonResponse();

        if(!$entity){
            // message: page nog found
            // status: 404
            $response->setData(['statuscode' => 404]);
        }else{
            // create the object for the new value
            $entityTableName = "App\\Entity\\".$entity->getTablename();
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
