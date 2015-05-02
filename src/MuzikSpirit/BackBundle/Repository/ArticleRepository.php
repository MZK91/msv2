<?php

namespace MuzikSpirit\BackBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ArticleRepository extends EntityRepository
{

    /**
     * Création de la réquete pour récupérer tous les "articles" avec CreateQueryBuilder
     */
    public function getListArticleQuery(){
        $query = $this->createQueryBuilder('article')
            ->orderBy('article.date', 'DESC');

        return $query;
    }
    /**
     * Récupération la liste complète des articles
     */
    public function getResultArticle(){
        $query = $this->getListArticleQuery()->getQuery();

        return $query->getResult();
    }

    /**
     * @param $find
     * @return \Doctrine\ORM\QueryBuilder
     * Création de la réquète de recherche d'articles
     */
    public function searchArticleQuery($find)
    {
        $query = $this->createQueryBuilder('article')
            ->where('clip.titre LIKE :find')
            ->orderBy('clip.date', 'DESC')
            ->setParameter('find', '%' . $find . '%');

        return $query;
    }

    public function getCountArticle(){
        $query = $this->getEntityManager()->createQuery(
            "SELECT count(article.titre) AS nbart
            FROM MuzikSpiritBackBundle:Article AS article"
        );
        return $query->getSingleScalarResult();
    }

    public function getOldestArticle(){
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            'SELECT article
            FROM MuzikSpiritBackBundle:Article AS article
            ORDER BY article.date ASC'
        )->setMaxResults(1);
        $article = $query->getSingleResult();

        return $article;
    }
}