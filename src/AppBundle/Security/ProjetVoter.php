<?php

namespace AppBundle\Security;

use AppBundle\Entity\Projet;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

/**
 * Projet voter
 */
class ProjetVoter extends Voter
{
    const VIEW = 'view';
    const EDIT = 'edit';

    private $decisionManager;

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [
            self::VIEW,
            self::EDIT,
        ])) {
            return false;
        }

        if (!$subject instanceof Projet) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        /* @var $projet Projet */
        $user = $subject;

        /* @var $user User */
        $user = $token->getUser();

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($subject, $token);
            case self::EDIT:
                return $this->canEdit($subject, $token);
            default:
                return false;
        }
    }

    private function canView(Projet $projet, TokenInterface $token)
    {
        $viewAll = $this->decisionManager->decide($token, ['ROLE_VIEW_ALL']);

        if ($viewAll) {
            return true;
        }

        return $projet->getOrigine() == $token->getUser();
    }

    private function canEdit(Projet $projet, TokenInterface $token)
    {
        $editAll = $this->decisionManager->decide($token, ['ROLE_EDIT_ALL']);

        if ($editAll) {
            return true;
        }

        return $projet->getOrigine() == $token->getUser();
    }
}
