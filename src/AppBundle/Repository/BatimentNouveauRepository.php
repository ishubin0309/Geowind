<?php

namespace AppBundle\Repository;

use Doctrine\ORM\Query;

class BatimentNouveauRepository extends EntityRepository
{
    public function getFindAllQueryBuilder()
    {
        return $this->createQueryBuilder('b')
            ->select('b')
            ->orderBy('b.nom', 'ASC')
        ;
    }
}
