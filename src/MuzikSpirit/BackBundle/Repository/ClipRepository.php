<?php

namespace MuzikSpirit\BackBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ClipRepository extends EntityRepository
{
    public function getListClipQuery(){
        $query = $this->getEntityManager()
            ->createQuery(
                "SELECT clip FROM MuzikSpiritBackBundle:Clip clip ORDER BY clip.id DESC"
            );
        return $query;
    }

    public function getListClip(){
        $query = $this->getListClipQuery();
        return $query->getResult();
    }

}