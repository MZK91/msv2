<?php

namespace MuzikSpirit\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ArtisteController extends Controller
{
    public function listAction($page)
    {

        $limit = $this->container->getParameter('max_articles');

        $em = $this->getDoctrine()->getManager();

        $dql   = "SELECT artiste FROM MuzikSpiritBackBundle:Artiste artiste ORDER BY artiste.id DESC";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $paginator = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render('MuzikSpiritBackBundle:Artiste:list.html.twig',
            array(
                'titre' => 'Artiste',
                'page' => $page,
                'pagination' => $paginator
            )
        );
    }
}