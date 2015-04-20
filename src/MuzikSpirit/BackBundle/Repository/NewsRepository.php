<?php

namespace MuzikSpirit\BackBundle\Repository;

use Doctrine\ORM\EntityRepository;
use MuzikSpirit\BackBundle\Utilities\Search;

class NewsRepository extends EntityRepository
{
    public function getListNews(){

        $dql   = "SELECT n FROM MuzikSpiritBackBundle:News n ORDER BY n.id DESC";
        $query = $em->createQuery($dql);
        return $query->getResult();
    }

}