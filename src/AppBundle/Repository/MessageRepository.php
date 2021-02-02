<?php

namespace AppBundle\Repository;

/**
 * @author Stéphane Ear <stephaneear@gmail.com>
 */
class MessageRepository extends EntityRepository
{
    public function findAll()
    {
        $query = $this->createQueryBuilder('message')
                ->select(['message', 'mairie', 'user'])
                ->leftJoin('message.mairie', 'mairie')
                ->leftJoin('message.createdBy', 'user')
                ->orderBy('message.createdAt', 'ASC')
        ;

        return $query->getQuery()->getResult();
    }
}
