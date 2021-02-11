<?php

namespace AppBundle\Repository;

/**
 * User Repository
 *
 * @author Stéphane Ear <stephaneear@gmail.com>
 */
class UserRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->getFindAllQueryBuilder()->getQuery()->getResult();
    }

    public function getFindAllQueryBuilder()
    {
        return $this->createQueryBuilder('u')
                    ->select('u')
                    ->orderBy('u.nom', 'ASC')
                ;

    }

    public function getFindAllTelephones()
    {
        return $this->createQueryBuilder('u')
                    ->select('u.id, u.telephone')
                    ->getQuery()
                    ->getResult()
                ;

    }
}
