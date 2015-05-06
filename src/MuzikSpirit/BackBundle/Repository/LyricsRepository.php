<?php

namespace MuzikSpirit\BackBundle\Repository;

use Doctrine\ORM\EntityRepository;

class LyricsRepository extends EntityRepository
{

    /**
     * Création de la réquete pour récupérer tous les "lyrics" avec CreateQueryBuilder
     */
    public function getListLyricsQuery(){
        $query = $this->createQueryBuilder('lyrics')
            ->orderBy('lyrics.id', 'DESC');

        return $query;
    }
    /**
     * Récupération la liste complète des articles "Lyrics"
     */
    public function getResultLyrics(){
        $query = $this->getListLyricsQuery()->getQuery();

        return $query->getResult();
    }

    /**
     * @param $find
     * @return \Doctrine\ORM\QueryBuilder
     * Création de la réquète de recherche d'articles de type "Lyrics" avec le paramètre transmis en paramètre
     */
    public function searchLyricsQuery($find)
    {
        $query = $this->createQueryBuilder('lyrics')
            ->where('lyrics.titre LIKE :find')
            ->orderBy('lyrics.id', 'DESC')
            ->setParameter('find', '%' . $find . '%');

        return $query;
    }

    /**
     * @param $find
     * @return \Doctrine\ORM\QueryBuilder
     * Création d'une requete de recherche qui retourne uniquement le titre et le lien de l'article
     */

    public function searchLyricsLinkQuery($find)
    {
        $query = $this->createQueryBuilder('lyrics')
            ->select('lyrics.titre, lyrics.slug, lyrics.id')
            ->where('lyrics.titre LIKE :find')
            ->orderBy('lyrics.id', 'DESC')
            ->setParameter('find', '%' . $find . '%');

        return $query;
    }

}