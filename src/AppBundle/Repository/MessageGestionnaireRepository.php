<?php

namespace AppBundle\Repository;

/**
 * @author Haffoudhi
 */
class MessageGestionnaireRepository extends EntityRepository
{
    public function findAll()
    {
        $query = $this->createQueryBuilder('message')
                ->select(['message', 'gestionnaire', 'user'])
                ->leftJoin('message.gestionnaire', 'gestionnaire')
                ->leftJoin('message.createdBy', 'user')
                ->orderBy('message.createdAt', 'ASC')
        ;

        return $query->getQuery()->getResult();
    }
}
