<?php

namespace AppBundle\Repository;

/**
 * @author Haffoudhi
 */
class MessageParcellesRepository extends EntityRepository
{
    public function findAll()
    {
        $query = $this->createQueryBuilder('message')
                ->select(['message', 'projet', 'user'])
                ->leftJoin('message.projet', 'projet')
                ->leftJoin('message.createdBy', 'user')
                ->orderBy('message.createdAt', 'ASC')
        ;

        return $query->getQuery()->getResult();
    }
}
