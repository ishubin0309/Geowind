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
        return $this->createQueryBuilder('r')
                    ->select('r')
                    ->orderBy('r.nom', 'ASC')
                ;

    }

    public function getFindAllTelephones()
    {
        return $this->createQueryBuilder('r')
                    ->select('r.id, r.telephone')
                    ->getQuery()
                    ->getResult()
                ;

    }
}
