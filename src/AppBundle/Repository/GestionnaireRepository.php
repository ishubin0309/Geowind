<?php

namespace AppBundle\Repository;

/**
 * @author Haffoudhi
 */
class GestionnaireRepository extends EntityRepository
{
    public function findAll()
    {
        $query = $this->createQueryBuilder('gestionnaire')
                ->select(['gestionnaire', 'departement'])
                ->leftJoin('gestionnaire.departement', 'departement')
        ;

        return $query->getQuery()->getResult();
    }
}
