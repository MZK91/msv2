<?php

namespace MuzikSpirit\BackBundle\Repository;

use Doctrine\ORM\EntityRepository;
use MuzikSpirit\BackBundle\Utilities\Search;

class NewsRepository extends EntityRepository
{

    /**
    * Création de la réquete pour récupérer tous les articles news avec CreateQueryBuilder
    */
    public function getListNewsQuery(){
        $query = $this->createQueryBuilder('news')
            ->orderBy('news.id', 'DESC');

        return $query;
    }
    /**
    * Récupération la liste complète des articles News
    */
    public function getResultNews(){
        $query = $this->getListNewsQuery()->getQuery();

        return $query->getResult();
    }

    /**
     * @param $find
     * @return \Doctrine\ORM\QueryBuilder
     * Création de la réquète de recherche d'articles de type news avec le paramètre transmis en paramètre
     */
    public function searchNewsQuery($find)
    {
        $query = $this->createQueryBuilder('news')
            ->where('news.titre LIKE :find')
            ->orderBy('news.id', 'DESC')
            ->setParameter('find', '%' . $find . '%');

        return $query;
    }

}