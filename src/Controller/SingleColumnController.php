<?php

namespace App\Controller;

use App\Entity\SingleColumnName;
use App\Entity\Rayon;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class SingleColumnController extends AbstractController{
    /**
     * @Route("/add/name/{slug}", name="add_single")
     */
    public function add($slug){
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $repository = $this->getDoctrine()->getRepository(SingleColumnName::class);
        // look if the slug is in the SingleColumnName-table
        $entity = $repository->findOneBy(['name' => $slug]);

        dump($entity);

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
    public function fetch(Request $request) : Response {
        $data = json_decode($request->getContent(), true);

        // $repository = $this->getDoctrine()->getRepository(Rayon::class);

        // // look for a single Rayon by name
        // $rayon = $repository->findOneBy(['name' => $data["rayon"]]);

        // make the
        $rayon = new Rayon();
        $rayon->setName($data["name"]);

        $entityManager = $this->getDoctrine()->getManager();

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($rayon);

        $response = new JsonResponse();

        try {
            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();
            $response->setData(['message' => $rayon->getName()." succesvol toegevoegd."]);
            // $message = $rayon->getName()." succesvol toegevoegd.";
        }
        catch (UniqueConstraintViolationException $e) {
            // $error = $rayon->getName()." bestaat reeds.";
            $response->setData(['error' => $rayon->getName()." bestaat reeds."]);
        }
        catch (Exception $e) {
            $response->setData(['error' => $rayon->getName()." werd niet toegevoegd."]);
        }

        // return the JsonRespons if saved
        // return new JsonResponse(
        //     ['message' => $message,
        //     'error' => $error]);
        return $response;
    }
}
