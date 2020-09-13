<?php

namespace App\Security\Voter;

use App\Entity\Camp;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class CampVoter extends Voter
{
    const VIEW = 'view';
    const EDIT = 'edit';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject)
    {
        if (!in_array($attribute, [self::VIEW, self::EDIT])) {
            return false;
        }

        // only vote on `Camp` objects
        if (!$subject instanceof Camp) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        // return true;
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }

        if (!$this->security->isGranted('ROLE_USER')) {
            return false;
        }

        $user = $token->getUser();

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        /** @var Camp $camp */
        $camp = $subject;

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($camp, $user);
            case self::EDIT:
                return $this->canEdit($camp, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canView(Camp $camp, User $user)
    {
        // if they can edit, they can view
        if ($this->canEdit($camp, $user)) {
            return true;
        }
    }

    private function canEdit(Camp $camp, User $user)
    {
        return $user === $camp->getUser();
    }
}