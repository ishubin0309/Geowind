<?php

namespace AppBundle\Repository;

use Doctrine\ORM\Query;

/**
 * @author Stéphane Ear <stephaneear@gmail.com>
 */
class MairieRepository extends EntityRepository
{
    public function searchTerm($term)
    {
        $query = $this->createQueryBuilder('c')
                    ->select('c, LENGTH(c.mairie) len')
                    ->where('c.commune LIKE :commune')
                    ->orderBy('len', 'ASC')
                    ->setFirstResult(0)
                    ->setMaxResults(30)
                    ->setParameter('commune', '%' . $term . '%')
                ;

        $results = $query->getQuery()->getResult(Query::HYDRATE_ARRAY);

        $data = [];

        foreach ($results as $result) {
            $arr = [
                'insee' => $result[0]['insee'],
                'id' => $result[0]['id'],
                'telephone' => $result[0]['telephone'],
                'text' => $result[0]['mairie'] . ' (' . $result[0]['codePostal'] . ')',
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
