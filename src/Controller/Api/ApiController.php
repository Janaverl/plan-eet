<?php

namespace App\Controller\Api;

use App\Service\ValidateRoute;
use App\Service\Api\ApiProblem;
use App\Service\Api\ApiProblemException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ApiController extends AbstractController
{
    protected function throwExceptionIfNotExcists($object) : void
    {
        if (!$object) {
            throw new ApiProblemException(new ApiProblem(404));
        }
    }
    protected function throwExceptionIfUnauthorizedUser($object) : void
    {
        if (!$this->isGranted('ROLE_ADMIN') && !ValidateRoute::isCreatedByUser($this->getUser(), $object->getUser())) {
            throw new ApiProblemException(new ApiProblem(401));
        }
    }

}