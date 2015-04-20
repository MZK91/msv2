<?php

namespace MuzikSpirit\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LyricsController extends Controller
{
    public function listAction($page)
    {

        $limit = $this->container->getParameter('max_articles');

        $em = $this->getDoctrine()->getManager();

        $dql   = "SELECT lyrics FROM MuzikSpiritBackBundle:Lyrics lyrics ORDER BY lyrics.id DESC";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $paginator = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render('MuzikSpiritBackBundle:Lyrics:list.html.twig',
            array(
                'titre' => 'Lyrics',
                'page' => $page,
                'pagination' => $paginator
            )
        );
    }
}