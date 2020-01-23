<?php

namespace App\Service;

class ValidateRoute
{
    /**
     * @param string $slug
     * @param string $name
     * @return boolean
     */
    public function object_matches_to_slug(string $slug, string $name): bool
    {
        if ($name === $slug) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param object $user
     * @param object $objectBelongsToUser
     * @return boolean
     */
    public function is_created_by_user(object $user, object $objectBelongsToUser): bool
    {
        if ($user == $objectBelongsToUser) {
            return true;
        } else {
            return false;
        }
    }
}
