<?php

namespace App\Controller;

use App\Entity\SingleColumnName;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SingleValueController extends AbstractController
{
    public function create($theme)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // check if the theme is in the SingleColumnName-table
        $entity = $this->getDoctrine()
            ->getRepository(SingleColumnName::class)
            ->findOneBy(['name' => $theme]);

        if (empty($entity)) {
            return $this->render('general/index.html.twig');
        }

        $repositoryPathForClass = "App\\Entity\\" . $entity->getTablename();

        $result = $this->getDoctrine()
            ->getRepository($repositoryPathForClass)
            ->findAll();

        return $this->render('single_column/add.html.twig', [
            'name' => $entity->getTranslation(),
            'slug' => $theme,
            'values' => $result,
            'API' => $entity->getAPI(),
        ]);
    }
}
