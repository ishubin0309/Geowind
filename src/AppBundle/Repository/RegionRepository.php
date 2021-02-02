<?php

namespace AppBundle\Repository;

/**
 * User Repository
 *
 * @author Stéphane Ear <stephaneear@gmail.com>
 */
class RegionRepository extends EntityRepository
{
    public function findAll()
    {
        $query = $this->createQueryBuilder('r')
                    ->select('r')
                    ->orderBy('r.nom', 'ASC');
                ;

        return $query->getQuery()->getResult();
    }

    public function findAllIndexByCode()
    {
        $query = $this->createQueryBuilder('r', 'r.code')
                    ->select('r')
                    ->orderBy('r.nom', 'ASC');
                ;

        return $query->getQuery()->getResult();
    }
}
