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

    public function findAllCount()
    {
        $query = $this->createQueryBuilder('g', 'g.id')
                    ->select('COUNT(g)')
                ;

        return $query->getQuery()->getSingleScalarResult();
    }
    
    public function emptyTable()
    {
        $query = $this->createQueryBuilder('g')->delete('AppBundle:Gestionnaire', 'g');

        return $query->getQuery()->execute();
    }
}
