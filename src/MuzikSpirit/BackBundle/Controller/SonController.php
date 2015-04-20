<?php

namespace MuzikSpirit\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SonController extends Controller
{

    public function listAction($page)
    {

        $limit = $this->container->getParameter('max_articles');

        $em = $this->getDoctrine()->getManager();

        $dql   = "SELECT son FROM MuzikSpiritBackBundle:Son son ORDER BY son.id DESC";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $paginator = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render('MuzikSpiritBackBundle:Son:list.html.twig',
            array(
                'titre' => 'Son',
                'page' => $page,
                'pagination' => $paginator
            )
        );
    }
}