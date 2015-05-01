<?php

namespace MuzikSpirit\BackBundle\Repository;

use Doctrine\ORM\EntityRepository;
use MuzikSpirit\BackBundle\Utilities\Search;

class ClipRepository extends EntityRepository
{

    /**
     * Création de la réquete pour récupérer tous les "clip" avec CreateQueryBuilder
     */
    public function getListClipQuery(){
        $query = $this->createQueryBuilder('clip')
            ->orderBy('clip.id', 'DESC');

        return $query;
    }
    /**
     * Récupération la liste complète des articles "Clip"
     */
    public function getResultClip(){
        $query = $this->getListNewsQuery()->getQuery();

        return $query->getResult();
    }

    /**
     * @param $find
     * @return \Doctrine\ORM\QueryBuilder
     * Création de la réquète de recherche d'articles de type "Clip" avec le paramètre transmis en paramètre
     */
    public function searchClipQuery($find)
    {
        $query = $this->createQueryBuilder('clip')
            ->where('clip.titre LIKE :find')
            ->orderBy('clip.id', 'DESC')
            ->setParameter('find', '%' . $find . '%');

        return $query;
    }

}