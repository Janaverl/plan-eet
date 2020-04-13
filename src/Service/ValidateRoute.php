<?php

namespace App\Service;

use Symfony\Component\Routing\RouterInterface;

class ValidateRoute
{
    /**
     * @param string $slug
     * @param string $name
     * @return boolean
     */
    public function hasMatchingSlug(string $slug, string $name): bool
    {
        if ($name === $slug) {
            return true;
        }

        return false;
        
    }

/**
 *
 * @param object $user
 * @param object $objectBelongsToUser
 * @return boolean
 */
    public function isCreatedByUser(object $user, object $objectBelongsToUser): bool
    {
        if ($user == $objectBelongsToUser) {
            return true;
        }
        
        return false;

    }
}
