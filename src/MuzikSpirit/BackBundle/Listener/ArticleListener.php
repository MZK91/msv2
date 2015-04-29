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
        }
    }

    public function postPersist(LifecycleEventArgs $args){
        $entity = $args->getEntity();
        $em = $args->getEntityManager();
        $article = new Article();
        if($entity instanceof News){
            $article->setArticleId($entity->getId());
            $article->setTypeArticle($entity->getTypeArticle()->getId());
            $em->persist($article);
            $em->flush();
        }
    }

    public function preRemove(LifecycleEventArgs $args){
        $entity = $args->getEntity();
        $em = $args->getEntityManager();
        if($entity instanceof News){
            $q = $em->createQuery('delete from MuzikSpiritBackBundle:Article art
            where art.articleId = '.$entity->getId().' AND art.typeArticle = '.$entity->getTypeArticle()->getId());
            $q->execute();
        }
    }
}