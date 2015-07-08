<?php

namespace MuzikSpirit\BackBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class TypeImageRepository
 * @package MuzikSpirit\BackBundle\Repository
 */
class TypeImageRepository extends EntityRepository
{
    /**
     * @param integer $type
     * @return object
     */
    public function getTypeImage($type)
    {
        $query = $this->createQueryBuilder('typeImage')
            ->where('typeImage.id = :type')
            ->setParameter('type', $type)
            ->setMaxResults(1)->getQuery();
        $typeImage = $query->getSingleResult();

        return $typeImage;
    }

}