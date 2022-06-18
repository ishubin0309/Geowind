<?php

namespace AppBundle\Repository;

use Doctrine\ORM\Query;

/**
 * @author Haffoudhi
 */
class GestionnaireRepository extends EntityRepository
{
    public function searchTerm($term)
    {
        $query = $this->createQueryBuilder('c')
                    ->select('c, LENGTH(c.gestionnaire) len')
                    ->where('c.gestionnaire LIKE :gestionnaire')
                    ->orderBy('len', 'ASC')
                    ->setFirstResult(0)
                    ->setMaxResults(30)
                    ->setParameter('gestionnaire', '%' . $term . '%')
                ;

        $results = $query->getQuery()->getResult(Query::HYDRATE_ARRAY);

        $data = [];

        foreach ($results as $result) {
            $arr = [
                'insee' => $result[0]['insee'],
                'id' => $result[0]['id'],
                'telephone' => $result[0]['telephone'],
                'gestionnaire' => $result[0]['gestionnaire'],
                'text' => $result[0]['gestionnaire'],
            ];
            $data[] = $arr;
        }

        return $data;
    }

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
