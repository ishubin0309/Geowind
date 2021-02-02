<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository as DoctrineEntityRepository;

/**
 * @author Stéphane Ear <stephaneear@gmail.com>
 */
class EntityRepository extends DoctrineEntityRepository
{
    public function flush()
    {
        $this->_em->flush();
    }

    public function persist($entity)
    {
        $this->_em->persist($entity);
    }

    public function save($entity, $flush = true)
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function saveAndFlush($entity)
    {
        $this->save($entity);
        $this->flush();
    }

    public function remove($entity)
    {
        $this->_em->remove($entity);
    }

    public function getEntityManager()
    {
        return $this->_em;
    }
}
