<?php

namespace MuzikSpirit\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use MuzikSpirit\BackBundle\Entity\Clip;
use MuzikSpirit\BackBundle\Entity\Video;
use MuzikSpirit\BackBundle\Entity\Son;
use MuzikSpirit\BackBundle\Entity\Album;
use MuzikSpirit\BackBundle\Entity\Lyrics;
use MuzikSpirit\BackBundle\Entity\Artiste;

class MenuController extends Controller
{
    /**
     * Listing des clips
     *
     * @param $page
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @return string Le rendu de la vue
     */
    public function listAction($section,$type)
    {
        $limit = $this->container->getParameter('max_articles');
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('MuzikSpiritBackBundle:Clip')->getListClipQuery()->getQuery();

        $paginator  = $this->get('knp_paginator');
        $paginator = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render('MuzikSpiritFrontBundle:Clip:list.html.twig',
            array(
                'page' => $page,
                'pagination' => $paginator
            )
        );
    }

    /**
     * Affichage de l'article
     *
     * @param Clip $clip
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction(Clip $clip)
    {
        $clip = $clip;
        return $this->render('MuzikSpiritFrontBundle:Clip:view.html.twig',['clip' => $clip]);
    }
}
