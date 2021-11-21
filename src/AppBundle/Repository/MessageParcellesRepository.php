<?php

namespace AppBundle\Repository;

/**
 * @author Haffoudhi
 */
class MessageParcellesRepository extends EntityRepository
{
    public function findAll()
    {
        $query = $this->createQueryBuilder('messageParcelles')
                ->select(['messageParcelles', 'projet', 'user'])
                ->leftJoin('messageParcelles.projet', 'projet')
                ->leftJoin('messageParcelles.createdBy', 'user')
                ->orderBy('messageParcelles.createdAt', 'ASC')
        ;

        return $query->getQuery()->getResult();
    }
}
