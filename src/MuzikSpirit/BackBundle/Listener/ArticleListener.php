<?php
/**
 * Created by PhpStorm.
 * User: wac31
 * Date: 24/04/15
 * Time: 10:48
 */

namespace MuzikSpirit\BackBundle\Listener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use MuzikSpirit\BackBundle\Entity\Album;
use MuzikSpirit\BackBundle\Entity\Article;
use MuzikSpirit\BackBundle\Entity\Artiste;
use MuzikSpirit\BackBundle\Entity\Clip;
use MuzikSpirit\BackBundle\Entity\Lifestyle;
use MuzikSpirit\BackBundle\Entity\Lyrics;
use MuzikSpirit\BackBundle\Entity\News;
use MuzikSpirit\BackBundle\Entity\Son;
use MuzikSpirit\BackBundle\Entity\Video;
use MuzikSpirit\BackBundle\Utilities\Slug;

/**
 * Class AuthentificationListener
 * @package Store\BackendBundle\Listener
 */
class ArticleListener {

    public function checkInstance($entity){
        if($entity instanceof News || $entity instanceof Clip || $entity instanceof Video || $entity instanceof Son || $entity instanceof Lyrics || $entity instanceof Album || $entity instanceof Lifestyle || $entity instanceof Artiste){
            return true;
        }else{
            return false;
        }
    }

    public function prePersist(LifecycleEventArgs $args){
        $entity = $args->getEntity();
        if($this->checkInstance($entity)){
            $entity->setSlug(Slug::slug($entity->getTitre()));
        }
    }

    public function postPersist(LifecycleEventArgs $args){
        $entity = $args->getEntity();
        $em = $args->getEntityManager();
        $article = new Article();
        if($this->checkInstance($entity)){
            $nbr = $em->getRepository('MuzikSpiritBackBundle:Article')->getCountArticle();
            if($nbr > 200){
                $oldArticle = $em->getRepository('MuzikSpiritBackBundle:Article')->getOldestArticle();
                if($oldArticle != null){
                    $em->remove($oldArticle);
                    $em->flush();
                }
            }
            $article->setArticleId($entity->getId());
            $typeArticle = $em->getRepository('MuzikSpiritBackBundle:TypeArticle')->find($entity->getTypeArticle());
            $section = $em->getRepository('MuzikSpiritBackBundle:Section')->find($entity->getSection());
            $article->setSection($section);
            $article->setTypeArticle($typeArticle);
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
        if($this->checkInstance($entity)){
            $q = $em->createQuery(
                'delete from MuzikSpiritBackBundle:Article art
                where art.articleId = '.$entity->getId().'
                AND art.typeArticle = '.$entity->getTypeArticle()->getId());
            $q->execute();
        }
    }
}