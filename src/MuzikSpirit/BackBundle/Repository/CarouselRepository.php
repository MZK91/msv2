<?php

namespace MuzikSpirit\BackBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class CarouselRepository
 * @package MuzikSpirit\BackBundle\Repository
 */
class CarouselRepository extends EntityRepository
{

    /**
     * Création de la réquete pour récupérer tous les "carousel" avec CreateQueryBuilder
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getListCarouselQuery()
    {
        $query = $this->createQueryBuilder('carousel')
            ->orderBy('carousel.id', 'DESC');

        return $query;
    }

    /**
     * Récupération la liste complète des articles "Carousel"
     * @return array
     */
    public function getResultCarousel()
    {
        $query = $this->getListCarouselQuery()->getQuery();

        return $query->getResult();
    }

    /**
     * Création de la réquète de recherche d'articles de type "Carousel" avec le paramètre transmis en paramètre
     * @param string $find
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function searchCarouselQuery($find)
    {
        $query = $this->createQueryBuilder('carousel')
            ->where('carousel.titre LIKE :find')
            ->orderBy('carousel.id', 'DESC')
            ->setParameter('find', '%'.$find.'%');

        return $query;
    }

    /**
     * Création d'une requete de recherche qui retourne uniquement le titre et le lien de l'article
     * @param string $find
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function searchCarouselLinkQuery($find)
    {
        $query = $this->createQueryBuilder('carousel')
            ->select('carousel.titre,carousel.slug,carousel.id')
            ->where('carousel.titre LIKE :find')
            ->orderBy('carousel.id', 'DESC')
            ->setParameter('find', '%'.$find.'%');

        return $query;
    }

    /**
     * Création de la requête pour récupérer tous articles en fonction de la section
     *
     * @param int $section
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getListCarouselBySectionQuery($section)
    {
        $query = $this->createQueryBuilder('carousel')
            ->where('carousel.section = :section')
            ->orderBy('carousel.id', 'DESC')
            ->setParameter('section', $section);

        return $query;
    }

    /**
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @param int $limit
     * @return mixed
     * On récupére un nombre d'article en fonction de la limite définie en paramètre
     */
    public function getCarouselLimit($limit)
    {
        $query = $this->createQueryBuilder('carousel')
            ->orderBy('carousel.id', 'DESC')
            ->setMaxResults($limit)
            ->getQuery();
        $carousel = $query->getResult();

        return $carousel;
    }

}