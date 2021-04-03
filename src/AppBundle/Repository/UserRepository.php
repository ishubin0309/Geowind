<?php

namespace AppBundle\Repository;

use Doctrine\ORM\Query;

/**
 * User Repository
 *
 * @author Stéphane Ear <stephaneear@gmail.com>
 */
class UserRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->getFindAllQueryBuilder()->getQuery()->getResult();
    }

    public function getFindAllQueryBuilder()
    {
        return $this->createQueryBuilder('u')
                    ->select('u')
                    ->orderBy('u.nom', 'ASC')
                ;

    }

    public function getFindAllTelephones()
    {
        return $this->createQueryBuilder('u')
                    ->select('u.id, u.telephone')
                    ->getQuery()
                    ->getResult()
                ;
    }

    public function getFindPartenaires($id)
    {
        $query = $this->createQueryBuilder('u')
                    ->select('u.id, u.nom, u.prenom')
                    ->leftJoin('u.departements', 'd')
                    ->where('d.id = :id')
                    ->setParameter('id', $id)
                ;
        $results = $query->getQuery()->getResult(Query::HYDRATE_ARRAY);

        $data = [];

        foreach ($results as $result) {
            $arr = [
                'id' => $result['id'],
                'text' => $result['nom'] . ' ' . $result['prenom'],
            ];
            $data[] = $arr;
        }

        return $data;
    }

    public function getFindChefProjets($id)
    {
        $query = $this->createQueryBuilder('u')
                    ->select('u.id, u.nom, u.prenom')
                    ->leftJoin('u.departementsChefProjet', 'd')
                    ->where('d.id = :id')
                    ->setParameter('id', $id)
                ;
        $results = $query->getQuery()->getResult(Query::HYDRATE_ARRAY);

        $data = [];

        foreach ($results as $result) {
            $arr = [
                'id' => $result['id'],
                'text' => $result['nom'] . ' ' . $result['prenom'],
            ];
            $data[] = $arr;
        }

        return $data;
    }

    public function getFindChargeFonciers($id)
    {
        $query = $this->createQueryBuilder('u')
                    ->select('u.id, u.nom, u.prenom')
                    ->leftJoin('u.departementsChargeFoncier', 'd')
                    ->where('d.id = :id')
                    ->setParameter('id', $id)
                ;
        $results = $query->getQuery()->getResult(Query::HYDRATE_ARRAY);

        $data = [];

        foreach ($results as $result) {
            $arr = [
                'id' => $result['id'],
                'text' => $result['nom'] . ' ' . $result['prenom'],
            ];
            $data[] = $arr;
        }

        return $data;
    }
}
