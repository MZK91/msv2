<?php

namespace MuzikSpirit\BackBundle\Repository;

use Doctrine\ORM\EntityRepository;

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
        $query = $this->getListClipQuery()->getQuery();

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

    /**
     * @param $find
     * @return \Doctrine\ORM\QueryBuilder
     * Création d'une requete de recherche qui retourne uniquement le titre et le lien de l'article
     */

    public function searchClipLinkQuery($find)
    {
        $query = $this->createQueryBuilder('clip')
            ->select('clip.titre,clip.slug,clip.id')
            ->where('clip.titre LIKE :find')
            ->orderBy('clip.id', 'DESC')
            ->setParameter('find', '%' . $find . '%');

        return $query;
    }

    /**
     * Création de la requête pour récupérer tous articles en fonction de la section
     *
     * @param $section
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getListClipBySectionQuery($section)
    {
        $query = $this->createQueryBuilder('clip')
            ->where('clip.section = :section')
            ->orderBy('clip.id', 'DESC')
            ->setParameter('section', $section);
        return $query;
    }

    /**
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * On récupére un nombre d'article en fonction de la limite définie en paramètre
     */
    public function getClipLimit($limit){
        $query = $this->createQueryBuilder('clip')
            ->orderBy('clip.id', 'DESC')
            ->setMaxResults($limit)
            ->getQuery();
        $clip = $query->getResult();

        return $clip;
    }

}