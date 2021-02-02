<?php

namespace AppBundle\Repository;

use Doctrine\ORM\Query;

/**
 * @author Stéphane Ear <stephaneear@gmail.com>
 */
class ParcEolienRepository extends EntityRepository
{
    public function findByIdsIndexById(array $ids)
    {
        $query = $this->createQueryBuilder('c', 'c.id')
                    ->select('c')
                    ->where('c.id IN (:ids)')
                    ->setParameter('ids', $ids)
                ;

        return $query->getQuery()->getResult();
    }
    
    public function findAll()
    {
        $query = $this->createQueryBuilder('c', 'c.id')
                    ->select('c')
                ;

        return $query->getQuery()->getResult(Query::HYDRATE_ARRAY);
    }
}
