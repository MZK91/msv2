<?php

namespace MuzikSpirit\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ClipController extends Controller
{
    public function listAction($page)
    {

        $limit = $this->container->getParameter('max_articles');

        $em = $this->getDoctrine()->getManager();

        $dql   = "SELECT clip FROM MuzikSpiritBackBundle:Clip clip ORDER BY clip.id DESC";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $paginator = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render('MuzikSpiritBackBundle:Clip:list.html.twig',
            array(
                'titre'=>'News',
                'page' => $page,
                'pagination' => $paginator
            )
        );
    }
}