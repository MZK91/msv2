<?php

namespace MuzikSpirit\BackBundle\Repository;

use Doctrine\ORM\EntityRepository;

class NewsRepository extends EntityRepository
{
    public function getListNews($page,$limit){

        $news =
            $this->findBy(
                array(),
                array('id' => 'DESC'),
                $limit,
                ($limit * ($page-1))
            );
        return $news;
    }
}