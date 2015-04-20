<?php

namespace MuzikSpirit\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AlbumController extends Controller
{
    public function listAction($page)
    {

        $limit = $this->container->getParameter('max_articles');

        $em = $this->getDoctrine()->getManager();

        $dql   = "SELECT album FROM MuzikSpiritBackBundle:Album album ORDER BY album.id DESC";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $paginator = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render('MuzikSpiritBackBundle:Album:list.html.twig',
            array(
                'titre' => 'Album',
                'page' => $page,
                'pagination' => $paginator
            )
        );
    }
}