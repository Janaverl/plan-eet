<?php

namespace App\Service;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

/**
 * Undocumented class
 */
class Addvalue
{
    /**
     * @param object $entityManager
     * @return integer
     */
    public function tryCatch(object $entityManager): int
    {
        try {
            // message: created
            // status: 201

            // actually executes the queries
            $entityManager->flush();
            $response = 201;
        } catch (UniqueConstraintViolationException $e) {
            // message: Unprocessable Entity
            // status: 422
            $response = 422;
        } catch (Exception $e) {
            // message: bad request
            // status: 400
            $response = 400;
        }
        return $response;
    }
}
