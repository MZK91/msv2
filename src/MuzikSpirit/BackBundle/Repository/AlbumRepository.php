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

    /**
     * Création de la requête pour récupérer tous articles en fonction de la section
     *
     * @param $section
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getListAlbumBySectionQuery($section)
    {
        $query = $this->createQueryBuilder('album')
            ->where('album.section = :section')
            ->orderBy('album.id', 'DESC')
            ->setParameter('section', $section);
        return $query;
    }

    /**
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * On récupére un nombre d'article en fonction de la limite définie en paramètre
     */
    public function getAlbumLimit($limit){
        $query = $this->createQueryBuilder('album')
            ->orderBy('album.id', 'DESC')
            ->setMaxResults($limit)
            ->getQuery();
        $album = $query->getResult();

        return $album;
    }

}