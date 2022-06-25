<?php

namespace AppBundle\Repository;

/**
 * @author Haffoudhi
 */
class MessageGestionnaireRepository extends EntityRepository
{
    public function findAll()
    {
        $query = $this->createQueryBuilder('m')
                ->select(['m', 'gestionnaire', 'user'])
                ->leftJoin('m.gestionnaire', 'gestionnaire')
                ->leftJoin('m.createdBy', 'user')
                ->orderBy('m.createdAt', 'ASC')
        ;

        return $query->getQuery()->getResult();
    }
}
