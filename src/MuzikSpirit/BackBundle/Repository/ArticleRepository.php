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

    /**
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * On récupére un nombre d'article en fonction de la limite définie en paramètre
     */
    public function getArticleLimit($limit){
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            'SELECT article
            FROM MuzikSpiritBackBundle:Article AS article
            ORDER BY article.date DESC'
        )->setMaxResults($limit);
        $article = $query->getResult();

        return $article;
    }

    /**
     * @param $articleId
     * @param $TypeArticle
     * @return mixed
     * On récupére un article en fonctrion de son id et de son type
     */
    public function getArticle($articleId,$TypeArticle){
        $em = $this->getEntityManager();
        $query = $this->createQueryBuilder('article')
        ->where('article.typeArticle = :TypeArticle')
        ->andWhere("article.articleId = :articleId ")
        ->setParameter('TypeArticle', $TypeArticle )
        ->setParameter('articleId', $articleId )
        ->setMaxResults(1)->getQuery();
        $article = $query->getSingleResult();

        return $article;
    }

    /**
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * On récupére l'élément le plus vieux dans la table Article
     */
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

    /**
     * @param $year
     * @param $month
     * @param $day
     * @return mixed
     */

    public function findArticleDay($day)
    {
        $post = $this->getTable()->createQuery('article')
            ->where('DAY(p.post_date) = ?', $day)
            ->fetchOne();
        return $post;
    }
}