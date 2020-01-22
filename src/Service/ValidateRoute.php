<?php

namespace App\Service;

class ValidateRoute
{
    public function has_matching_slug(string $slug, string $name): bool
    {
        if ($name === $slug) {
            return true;
        } else {
            return false;
        }
    }
    public function is_created_by_user(object $user, object $objectBelongsToUser): bool
    {
        if ($user == $objectBelongsToUser) {
            return true;
        } else {
            return false;
        }
    }
}
