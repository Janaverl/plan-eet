<?php

namespace App\Service;

use Symfony\Component\Routing\RouterInterface;

class ValidateRoute
{
    private $router;

    public function __construct(
        RouterInterface $router
    ) {
        $this->router = $router;
    }

    /**
     * @param string $slug
     * @param string $name
     * @return boolean
     */
    public function hasMatchingSlug(string $slug, string $name): bool
    {
        if ($name === $slug) {
            return true;
        } else {
            return false;
        }
    }

/**
 * Undocumented function
 *
 * @param object $user
 * @param object $objectBelongsToUser
 * @return boolean
 */
    public function isCreatedByUser(object $user, object $objectBelongsToUser): bool
    {
        if ($user == $objectBelongsToUser) {
            return true;
        } else {
            return false;
        }
    }
}
