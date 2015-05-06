<?php

namespace MuzikSpirit\BackBundle\Repository;

use Doctrine\ORM\EntityRepository;

class LifestyleRepository extends EntityRepository
{

    /**
     * Création de la réquete pour récupérer tous les "lifestyle" avec CreateQueryBuilder
     */
    public function getListLifestyleQuery(){
        $query = $this->createQueryBuilder('lifestyle')
            ->orderBy('lifestyle.id', 'DESC');

        return $query;
    }
    /**
     * Récupération la liste complète des articles "Lifestyle"
     */
    public function getResultLifestyle(){
        $query = $this->getListLifestyleQuery()->getQuery();

        return $query->getResult();
    }

    /**
     * @param $find
     * @return \Doctrine\ORM\QueryBuilder
     * Création de la réquète de recherche d'articles de type "Lifestyle" avec le paramètre transmis en paramètre
     */
    public function searchLifestyleQuery($find)
    {
        $query = $this->createQueryBuilder('lifestyle')
            ->where('lifestyle.titre LIKE :find')
            ->orderBy('lifestyle.id', 'DESC')
            ->setParameter('find', '%' . $find . '%');

        return $query;
    }

    /**
     * @param $find
     * @return \Doctrine\ORM\QueryBuilder
     * Création d'une requete de recherche qui retourne uniquement le titre et le lien de l'article
     */

    public function searchLifestyleLinkQuery($find)
    {
        $query = $this->createQueryBuilder('lifestyle')
            ->select('lifestyle.titre, lifestyle.slug, lifestyle.id')
            ->where('lifestyle.titre LIKE :find')
            ->orderBy('lifestyle.id', 'DESC')
            ->setParameter('find', '%' . $find . '%');

        return $query;
    }

}