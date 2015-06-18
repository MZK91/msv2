<?php

namespace MuzikSpirit\BackBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ArtisteRepository extends EntityRepository
{

    /**
     * Création de la réquete pour récupérer tous les "artiste" avec CreateQueryBuilder
     */
    public function getListArtisteQuery(){
        $query = $this->createQueryBuilder('artiste')
            ->orderBy('artiste.id', 'DESC');

        return $query;
    }
    /**
     * Récupération la liste complète des articles "Artiste"
     */
    public function getResultArtiste(){
        $query = $this->getListArtisteQuery()->getQuery();

        return $query->getResult();
    }

    /**
     * @param $find
     * @return \Doctrine\ORM\QueryBuilder
     * Création de la réquète de recherche d'articles de type "Artiste" avec le paramètre transmis en paramètre
     */
    public function searchArtisteQuery($find)
    {
        $query = $this->createQueryBuilder('artiste')
            ->where('artiste.titre LIKE :find')
            ->orderBy('artiste.id', 'DESC')
            ->setParameter('find', '%' . $find . '%');

        return $query;
    }

    /**
     * @param $find
     * @return \Doctrine\ORM\QueryBuilder
     * Création d'une requete de recherche qui retourne uniquement le titre et le lien de l'article
     */

    public function searchArtisteLinkQuery($find)
    {
        $query = $this->createQueryBuilder('artiste')
            ->select('artiste.titre,artiste.slug,artiste.id')
            ->where('artiste.titre LIKE :find')
            ->orderBy('artiste.id', 'DESC')
            ->setParameter('find', '%' . $find . '%');

        return $query;
    }

    /**
     * Création de la requête pour récupérer tous articles en fonction de la section
     *
     * @param $section
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getListArtisteBySectionQuery($section)
    {
        $query = $this->createQueryBuilder('artiste')
            ->where('artiste.section = :section')
            ->orderBy('artiste.id', 'DESC')
            ->setParameter('section', $section);
        return $query;
    }

    /**
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * On récupére un nombre d'article en fonction de la limite définie en paramètre
     */
    public function getArtisteLimit($limit){
        $query = $this->createQueryBuilder('artist')
            ->orderBy('artist.id', 'DESC')
            ->setMaxResults($limit)
            ->getQuery();
        $artist = $query->getResult();

        return $artist;
    }

}