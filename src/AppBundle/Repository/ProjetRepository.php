<?php

namespace AppBundle\Repository;

use AppBundle\Entity\User;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @author Stéphane Ear <stephaneear@gmail.com>
 */
class ProjetRepository extends EntityRepository
{

    public function searchTerm($term)
    {
        $query = $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.denomination LIKE :denomination OR p.id = :id')
            ->orderBy('id', 'DESC')
            ->setFirstResult(0)
            ->setMaxResults(10)
            ->setParameter('denomination', '%' . $term . '%')
            ->setParameter('id', $term)
        ;

        $results = $query->getQuery()->getResult(Query::HYDRATE_ARRAY);

        $data = [];

        foreach ($results as $result) {
            $denomination = $result[0]['denomination'];
            $arr = [
                'id' => $result[0]['id'],
                'text' => $denomination,
            ];
            $data[] = $arr;
        }

        return $data;
    }

    public function find($id)
    {
        $query = $this->createQueryBuilder('p')
                ->select(['p', 'f', 'pr', 't', 'b', 'c', 'd', 'r'])
                ->leftJoin('p.finances', 'f')
                ->leftJoin('p.proprietaires', 'pr')
                ->leftJoin('p.taches', 't')
                ->leftJoin('p.communes', 'c')
                ->leftJoin('f.bureau', 'b')
                ->leftJoin('p.departement', 'd')
                ->leftJoin('d.region', 'r')
                ->where('p.id = :id')
                ->setParameter('id', $id)
        ;

        return $query->getQuery()->getSingleResult();
    }

    public function findAll($archived = false)
    {
        $query = $this->createQueryBuilder('p')
                ->select(['p', 'f', 'pr', 't', 'b', 'c', 'd', 'r'])
                ->leftJoin('p.finances', 'f')
                ->leftJoin('p.proprietaires', 'pr')
                ->leftJoin('p.taches', 't')
                ->leftJoin('p.communes', 'c')
                ->leftJoin('f.bureau', 'b')
                ->leftJoin('p.departement', 'd')
                ->leftJoin('d.region', 'r')
                ->where('p.archived = :archived')
                ->orderBy('p.dateCreation', 'ASC')
                ->setParameter('archived', $archived)
        ;

        return $query->getQuery()->getResult();
    }

    public function findAllPaginator($archived = false, $offset=0, $limit=100)
    {
        $query = $this->createQueryBuilder('p')
                ->select(['p', 'f', 'pr', 't', 'b', 'c', 'd', 'r'])
                ->leftJoin('p.finances', 'f')
                ->leftJoin('p.proprietaires', 'pr')
                ->leftJoin('p.taches', 't')
                ->leftJoin('p.communes', 'c')
                ->leftJoin('f.bureau', 'b')
                ->leftJoin('p.departement', 'd')
                ->leftJoin('d.region', 'r')
                ->where('p.archived = :archived')
                // ->orderBy('p.dateCreation', 'ASC')
                ->setParameter('archived', $archived)
        ;

        return new Paginator($query->getQuery()->setFirstResult($offset)->setMaxResults($limit));
    }

    public function findAllForStatsPaginator($archived = false, $offset=0, $limit=100)
    {
        $query = $this->createQueryBuilder('p')
                ->select(['p', 'u', 'd', 'r'])
                ->leftJoin('p.origine', 'u')
                ->leftJoin('p.departement', 'd')
                ->leftJoin('d.region', 'r')
                ->where('p.archived = :archived')
                // ->orderBy('p.dateCreation', 'ASC')
                ->setParameter('archived', $archived)
        ;

        return new Paginator($query->getQuery()->setFirstResult($offset)->setMaxResults($limit));
    }

    public function findAllCount($archived = false)
    {
        $query = $this->createQueryBuilder('p')
                ->select('COUNT(p)')
                ->where('p.archived = :archived')
                ->setParameter('archived', $archived)
        ;

        return $query->getQuery()->getSingleScalarResult();
    }

    public function findAllByListePaginator($archived = false, $liste, $offset=0, $limit=100)
    {
        $query = $this->createQueryBuilder('p')
                ->select(['p', 'f', 'pr', 't', 'b', 'c', 'd', 'r'])
                ->leftJoin('p.finances', 'f')
                ->leftJoin('p.proprietaires', 'pr')
                ->leftJoin('p.taches', 't')
                ->leftJoin('p.communes', 'c')
                ->leftJoin('f.bureau', 'b')
                ->leftJoin('p.departement', 'd')
                ->leftJoin('d.region', 'r')
                ->where('p.liste = :liste')
                ->andWhere('p.archived = :archived')
                // ->orderBy('p.dateCreation', 'ASC')
                ->setParameter('liste', $liste)
                ->setParameter('archived', $archived)
        ;

        return new Paginator($query->getQuery()->setFirstResult($offset)->setMaxResults($limit));
    }

    public function findAllByListeCount($archived = false, $liste)
    {
        $query = $this->createQueryBuilder('p')
                ->select('COUNT(p)')
                ->where('p.liste = :liste')
                ->andWhere('p.archived = :archived')
                ->setParameter('liste', $liste)
                ->setParameter('archived', $archived)
        ;

        return $query->getQuery()->getSingleScalarResult();
    }

    public function findById(array $ids, $archived = false)
    {
        $query = $this->createQueryBuilder('p')
                ->select(['p', 'f', 'pr', 't', 'b', 'c', 'd', 'r'])
                ->leftJoin('p.finances', 'f')
                ->leftJoin('p.proprietaires', 'pr')
                ->leftJoin('p.taches', 't')
                ->leftJoin('p.communes', 'c')
                ->leftJoin('f.bureau', 'b')
                ->leftJoin('p.departement', 'd')
                ->leftJoin('d.region', 'r')
                ->where('p.id IN (:ids)')
                ->andWhere('p.archived = :archived')
                ->orderBy('p.dateCreation', 'ASC')
                ->setParameter('ids', $ids)
                ->setParameter('archived', $archived)
        ;

        return $query->getQuery()->getResult();
    }

    public function findUserForStatsProjets(User $user, $archived = false, $offset=0, $limit=100)
    {
        $query = $this->createQueryBuilder('p')
                ->select(['p', 'u', 'd', 'r'])
                ->leftJoin('p.origine', 'u')
                ->leftJoin('p.departement', 'd')
                ->leftJoin('d.region', 'r')
                ->where('(p.origine = :user OR p.chefProjet = :user OR p.chargeFoncier = :user OR p.partenaire = :user) AND p.archived = :archived')
                // ->orderBy('p.dateCreation', 'ASC')
                ->setParameter('user', $user)
                ->setParameter('archived', $archived)
        ;

        return new Paginator($query->getQuery()->setFirstResult($offset)->setMaxResults($limit));
    }

    public function findUserProjets(User $user, $archived = false, $offset=0, $limit=100)
    {
        $query = $this->createQueryBuilder('p')
                ->select(['p', 'f', 'pr', 't', 'b', 'c', 'd', 'r'])
                ->leftJoin('p.finances', 'f')
                ->leftJoin('p.proprietaires', 'pr')
                ->leftJoin('p.taches', 't')
                ->leftJoin('p.communes', 'c')
                ->leftJoin('f.bureau', 'b')
                ->leftJoin('p.departement', 'd')
                ->leftJoin('d.region', 'r')
                ->where('(p.origine = :user OR p.chefProjet = :user OR p.chargeFoncier = :user OR p.partenaire = :user) AND p.archived = :archived')
                // ->orderBy('p.dateCreation', 'ASC')
                ->setParameter('user', $user)
                ->setParameter('archived', $archived)
        ;

        return new Paginator($query->getQuery()->setFirstResult($offset)->setMaxResults($limit));
    }

    public function findAllUserProjets(User $user, $archived = false)
    {
        $query = $this->createQueryBuilder('p')
                ->select(['p', 'f', 'pr', 't', 'b', 'c', 'd', 'r'])
                ->leftJoin('p.finances', 'f')
                ->leftJoin('p.proprietaires', 'pr')
                ->leftJoin('p.taches', 't')
                ->leftJoin('p.communes', 'c')
                ->leftJoin('f.bureau', 'b')
                ->leftJoin('p.departement', 'd')
                ->leftJoin('d.region', 'r')
                ->where('(p.origine = :user OR p.chefProjet = :user OR p.chargeFoncier = :user OR p.partenaire = :user) AND p.archived = :archived')
                // ->orderBy('p.dateCreation', 'ASC')
                ->setParameter('user', $user)
                ->setParameter('archived', $archived)
        ;

        return $query->getQuery()->getResult();
    }

    public function findUserProjetsCount(User $user, $archived = false)
    {
        $query = $this->createQueryBuilder('p')
                ->select('COUNT(p)')
                ->where('(p.origine = :user OR p.chefProjet = :user OR p.chargeFoncier = :user OR p.partenaire = :user) AND p.archived = :archived')
                ->setParameter('user', $user)
                ->setParameter('archived', $archived)
        ;

        return $query->getQuery()->getSingleScalarResult();
    }

    public function findUserProjetsByListe(User $user, $archived = false, $liste, $offset=0, $limit=100)
    {
        $query = $this->createQueryBuilder('p')
                ->select(['p', 'f', 'pr', 't', 'b', 'c', 'd', 'r'])
                ->leftJoin('p.finances', 'f')
                ->leftJoin('p.proprietaires', 'pr')
                ->leftJoin('p.taches', 't')
                ->leftJoin('p.communes', 'c')
                ->leftJoin('f.bureau', 'b')
                ->leftJoin('p.departement', 'd')
                ->leftJoin('d.region', 'r')
                ->where('p.origine = :user')
                ->andWhere('p.liste = :liste')
                ->andWhere('p.archived = :archived')
                // ->orderBy('p.dateCreation', 'ASC')
                ->setParameter('user', $user)
                ->setParameter('liste', $liste)
                ->setParameter('archived', $archived)
        ;

        return new Paginator($query->getQuery()->setFirstResult($offset)->setMaxResults($limit));
    }

    public function findUserProjetsByListeCount(User $user, $liste, $archived = false)
    {
        $query = $this->createQueryBuilder('p')
                ->select('COUNT(p)')
                ->where('p.origine = :user')
                ->andWhere('p.liste = :liste')
                ->andWhere('p.archived = :archived')
                ->setParameter('user', $user)
                ->setParameter('liste', $liste)
                ->setParameter('archived', $archived)
        ;

        return $query->getQuery()->getSingleScalarResult();
    }

    public function findUserProjetsById(User $user, array $ids, $archived = false)
    {
        $query = $this->createQueryBuilder('p')
                ->select(['p', 'f', 'pr', 't', 'b', 'c', 'd', 'r'])
                ->leftJoin('p.finances', 'f')
                ->leftJoin('p.proprietaires', 'pr')
                ->leftJoin('p.taches', 't')
                ->leftJoin('p.communes', 'c')
                ->leftJoin('f.bureau', 'b')
                ->leftJoin('p.departement', 'd')
                ->leftJoin('d.region', 'r')
                ->where('(p.origine = :user OR p.chefProjet = :user OR p.chargeFoncier = :user OR p.partenaire = :user)')
                ->andWhere('p.id IN (:ids)')
                ->andWhere('p.archived = :archived')
                ->orderBy('p.dateCreation', 'ASC')
                ->setParameter('user', $user)
                ->setParameter('ids', $ids)
                ->setParameter('archived', $archived)
        ;

        return $query->getQuery()->getResult();
    }
}
