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
        $query = $this->createQueryBuilder('p', 'p.id')
                    ->select('p')
                    ->where('p.id IN (:ids)')
                    ->setParameter('ids', $ids)
                ;

        return $query->getQuery()->getResult();
    }
    
    public function findAllAsArray()
    {
        $query = $this->createQueryBuilder('p', 'p.id')
                    ->select('p')
                ;

        return $query->getQuery()->getResult(Query::HYDRATE_ARRAY);
    }
    
    public function findAllCount()
    {
        $query = $this->createQueryBuilder('p', 'p.id')
                    ->select('COUNT(p)')
                ;

        return $query->getQuery()->getSingleScalarResult();
    }
    
    public function emptyTable()
    {
        $query = $this->createQueryBuilder('p')->delete('AppBundle:ParcEolien', 'p');

        return $query->getQuery()->execute();
    }
}
