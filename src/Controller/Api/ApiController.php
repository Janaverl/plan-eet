<?php

namespace App\Controller\Api;

use Exception;
use App\Service\ValidateRoute;
use App\Service\Api\ApiProblem;
use App\Service\Api\ApiProblemException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\DBAL\Exception\NotNullConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ApiController extends AbstractController
{
    // protected function throwTestException() : void
    // {
    //     throw new ApiProblemException(new ApiProblem(422,  ApiProblem::TYPE_MUST_BE_UNIQUE_VALUE));
    // }

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
    
    protected function flushOrThrowException($entityManager) : void
    {
        try {
            $entityManager->flush();
        } catch (UniqueConstraintViolationException $e) {
            throw new ApiProblemException(new ApiProblem(422, ApiProblem::TYPE_MUST_BE_UNIQUE_VALUE));
        } catch (NotNullConstraintViolationException $e){
            throw new ApiProblemException(new ApiProblem(422));
        } catch (Exception $e) {
            throw new ApiProblemException(new ApiProblem(500));
        }
    }

}