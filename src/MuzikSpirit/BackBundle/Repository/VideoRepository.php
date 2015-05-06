<?php

namespace MuzikSpirit\BackBundle\Repository;

use Doctrine\ORM\EntityRepository;

class VideoRepository extends EntityRepository
{

    /**
     * Création de la réquete pour récupérer tous les "Video" avec CreateQueryBuilder
     */
    public function getListVideoQuery(){
        $query = $this->createQueryBuilder('video')
            ->orderBy('video.id', 'DESC');

        return $query;
    }
    /**
     * Récupération la liste complète des articles "Video"
     */
    public function getResultVideo(){
        $query = $this->getListVideoQuery()->getQuery();

        return $query->getResult();
    }

    /**
     * @param $find
     * @return \Doctrine\ORM\QueryBuilder
     * Création de la réquète de recherche d'articles de type "Video" avec le paramètre transmis en paramètre
     */
    public function searchVideoQuery($find)
    {
        $query = $this->createQueryBuilder('video')
            ->where('video.titre LIKE :find')
            ->orderBy('video.id', 'DESC')
            ->setParameter('find', '%' . $find . '%');

        return $query;
    }

    /**
     * @param $find
     * @return \Doctrine\ORM\QueryBuilder
     * Création d'une requete de recherche qui retourne uniquement le titre et le lien de l'article
     */

    public function searchVideoLinkQuery($find)
    {
        $query = $this->createQueryBuilder('video')
            ->select('video.titre,video.slug,video.id')
            ->where('video.titre LIKE :find')
            ->orderBy('video.id', 'DESC')
            ->setParameter('find', '%' . $find . '%');

        return $query;
    }

}