<?php

namespace AppBundle\Repository;

use Doctrine\ORM\Query;

/**
 * @author Stéphane Ear <stephaneear@gmail.com>
 */
class CommuneRepository extends EntityRepository
{
    public function searchTerm($term, $departement)
    {
        $query = $this->createQueryBuilder('c')
                    ->select('c, LENGTH(c.nom) len')
                    ->where('c.departement = :departement AND (c.nom LIKE :nom OR c.insee = :code)')
                    ->orderBy('len', 'ASC')
                    ->setFirstResult(0)
                    ->setMaxResults(10)
                    ->setParameter('departement', $departement)
                    ->setParameter('nom', '%' . $term . '%')
                    ->setParameter('code', $term)
                ;

        $results = $query->getQuery()->getResult(Query::HYDRATE_ARRAY);

        $data = [];

        foreach ($results as $result) {
            $arr = [
                'id' => $result[0]['id'],
                'text' => $result[0]['nomMiniscule'] . ' (' . $result[0]['insee'] . ')',
            ];
            $data[] = $arr;
        }

        return $data;
    }

    public function findByInseeIdxByInsee(array $insees)
    {
        $query = $this->createQueryBuilder('c', 'c.insee')
                    ->select('c')
                    ->where('c.insee IN (:insee)')
                    ->setParameter('insee', $insees)
                ;

        return $query->getQuery()->getResult();
    }
}
