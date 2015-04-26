<?php

namespace MuzikSpirit\BackBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ClipRepository extends EntityRepository
{
    public function getListClip(){
        $query = $this->getEntityManager()
            ->createQuery(
                "SELECT clip FROM MuzikSpiritBackBundle:Clip clip ORDER BY clip.id DESC"
            );
        return $query->getResult();
    }
}