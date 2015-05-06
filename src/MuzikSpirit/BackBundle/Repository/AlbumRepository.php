<?php

namespace MuzikSpirit\BackBundle\Repository;

use Doctrine\ORM\EntityRepository;

class AlbumRepository extends EntityRepository
{

    /**
     * Création de la réquete pour récupérer tous les "album" avec CreateQueryBuilder
     */
    public function getListAlbumQuery(){
        $query = $this->createQueryBuilder('album')
            ->orderBy('album.id', 'DESC');

        return $query;
    }
    /**
     * Récupération la liste complète des articles "Album"
     */
    public function getResultAlbum(){
        $query = $this->getListAlbumQuery()->getQuery();

        return $query->getResult();
    }

    /**
     * @param $find
     * @return \Doctrine\ORM\QueryBuilder
     * Création de la réquète de recherche d'articles de type "Album" avec le paramètre transmis en paramètre
     */
    public function searchAlbumQuery($find)
    {
        $query = $this->createQueryBuilder('album')
            ->where('album.titre LIKE :find')
            ->orderBy('album.id', 'DESC')
            ->setParameter('find', '%' . $find . '%');

        return $query;
    }

    /**
     * @param $find
     * @return \Doctrine\ORM\QueryBuilder
     * Création d'une requete de recherche qui retourne uniquement le titre et le lien de l'article
     */

    public function searchAlbumLinkQuery($find)
    {
        $query = $this->createQueryBuilder('album')
            ->select('album.titre,album.slug,album.id')
            ->where('album.titre LIKE :find')
            ->orderBy('album.id', 'DESC')
            ->setParameter('find', '%' . $find . '%');

        return $query;
    }

}