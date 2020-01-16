<?php

namespace App\Service;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class Addvalue
{
    public function tryCatch($entityManager)
    {
        try {
            // message: created
            // status: 201

            // actually executes the queries
            $entityManager->flush();
            $response = 201;
        }
        catch (UniqueConstraintViolationException $e) {
            // message: Unprocessable Entity
            // status: 422
            $response = 422;
        }
        catch (Exception $e) {
            // message: bad request
            // status: 400 
            $response = 400;
        }
        return $response;
    }
}

?>