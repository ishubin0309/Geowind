<?php

namespace AppBundle\Twig;

use AppBundle\Entity\User;
use AppBundle\Model\AvisMairie;
use Twig_Extension;
use Twig_SimpleFilter;

/**
 * @author Stéphane Ear <stephaneear@gmail.com>
 */
class RoleFormatterExtension extends Twig_Extension
{
    /**
     * @return array
     */
    public function getFilters()
    {
        return [
            new Twig_SimpleFilter('role_format', [$this, 'roleFormatter'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * @param User $user
     * @return string
     */
    public function roleFormatter(User $user)
    {
        if ($user->hasRole(User::ROLE_ADMIN)) {
            
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'role_formatter_extension';
    }
}
