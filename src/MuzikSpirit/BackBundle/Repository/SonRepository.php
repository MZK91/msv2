<?php

namespace MuzikSpirit\BackBundle\Repository;

use Doctrine\ORM\EntityRepository;

class SonRepository extends EntityRepository
{

    /**
     * Création de la réquete pour récupérer tous les "son" avec CreateQueryBuilder
     */
    public function getListSonQuery(){
        $query = $this->createQueryBuilder('son')
            ->orderBy('son.id', 'DESC');

        return $query;
    }
    /**
     * Récupération la liste complète des articles "Son"
     */
    public function getResultSon(){
        $query = $this->getListSonQuery()->getQuery();

        return $query->getResult();
    }

    /**
     * @param $find
     * @return \Doctrine\ORM\QueryBuilder
     * Création de la réquète de recherche d'articles de type "Son" avec le paramètre transmis en paramètre
     */
    public function searchSonQuery($find)
    {
        $query = $this->createQueryBuilder('son')
            ->where('son.titre LIKE :find')
            ->orderBy('son.id', 'DESC')
            ->setParameter('find', '%' . $find . '%');

        return $query;
    }

    /**
     * @param $find
     * @return \Doctrine\ORM\QueryBuilder
     * Création d'une requete de recherche qui retourne uniquement le titre et le lien de l'article
     */

    public function searchSonLinkQuery($find)
    {
        $query = $this->createQueryBuilder('son')
            ->select('son.titre,son.slug,son.id')
            ->where('son.titre LIKE :find')
            ->orderBy('son.id', 'DESC')
            ->setParameter('find', '%' . $find . '%');

        return $query;
    }

}