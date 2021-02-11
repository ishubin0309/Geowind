<?php

namespace AppBundle\Repository;

/**
 * @author Stéphane Ear <stephaneear@gmail.com>
 */
class DepartementRepository extends EntityRepository
{
    public function findAll()
    {
        $query = $this->createQueryBuilder('d')
                    ->select('d')
                    ->orderBy('d.nom', 'ASC');
                ;

        return $query->getQuery()->getResult();
    }

    public function findAllIndexByCode()
    {
        $query = $this->createQueryBuilder('d', 'd.code')
                    ->select('d')
                ;

        return $query->getQuery()->getResult();
    }

    public function getFindUsersAssignedDepartments($user)
    {
        if($user) {
            return $this->createQueryBuilder('d')
                ->select('d')
                ->join('d.users', 'u')
                ->where('u.id != :user')
                ->setParameter('user', $user)
                ->getQuery()
                ->getResult();
            ;
        }
        return $this->createQueryBuilder('d')
            ->select('d')
            ->join('d.users', 'u')
            ->getQuery()
            ->getResult();
        ;

    }
}
