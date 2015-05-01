<?php
/**
 * Created by PhpStorm.
 * User: wac31
 * Date: 24/04/15
 * Time: 10:48
 */

namespace MuzikSpirit\BackBundle\Listener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use MuzikSpirit\BackBundle\Entity\Article;
use MuzikSpirit\BackBundle\Entity\Clip;
use MuzikSpirit\BackBundle\Entity\News;
use MuzikSpirit\BackBundle\Utilities\Slug;

/**
 * Class AuthentificationListener
 * @package Store\BackendBundle\Listener
 */
class ArticleListener {
    public function prePersist(LifecycleEventArgs $args){
        $entity = $args->getEntity();
        if($entity instanceof News){
            $entity->setSlug(Slug::slug($entity->getTitre()));
        }elseif($entity instanceof Clip){
            $entity->setSlug(Slug::slug($entity->getTitre()));
        }
    }

    public function postPersist(LifecycleEventArgs $args){
        $entity = $args->getEntity();
        $em = $args->getEntityManager();
        $article = new Article();
        if($entity instanceof News || $entity instanceof Clip){
            $article->setArticleId($entity->getId());
            $article->setTypeArticle($entity->getTypeArticle()->getId());
            $article->setTitre($entity->getTitre());
            $article->setImage($entity->getImage());
            $article->setSlug($entity->getSlug());
            $article->setDate($entity->getDate());
            $em->persist($article);
            $em->flush();
        }
    }

    public function preRemove(LifecycleEventArgs $args){
        $entity = $args->getEntity();
        $em = $args->getEntityManager();
        if($entity instanceof News){
            $qb = $em->createQueryBuilder();
            $qb->delete('Article', 'art');
            $qb->andWhere($qb->expr()->eq('art.typeArticle', ':type'));
            $qb->andWhere($qb->expr()->eq('art.articleId', ':id'));
            $qb->setParameter(':type', $entity->getTypeArticle()->getId() );
            $qb->setParameter(':id', $entity->getId() );


            $q = $em->createQuery('delete from MuzikSpiritBackBundle:Article art
            where art.articleId = '.$entity->getId().' AND art.typeArticle = '.$entity->getTypeArticle()->getId());
            $qb->execute();
        }
    }
}