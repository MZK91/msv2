<?php

namespace MuzikSpirit\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NewsController extends Controller
{
    public function listAction($page)
    {
        $limit = $this->container->getParameter('max_articles');

        $em = $this->getDoctrine()->getManager();

        $emNews = $em->getRepository('MuzikSpiritBackBundle:News');

        $news = $emNews->getListNews($page,$limit);

        $dql   = "SELECT n FROM MuzikSpiritBackBundle:News n";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $page,
            $limit
        );


        return $this->render('MuzikSpiritBackBundle:News:list.html.twig',
            array(
                'news' => $news,
                'titre'=>'News',
                'page' => $page,
                'pagination' => $pagination
            )
        );
    }
        public function NewsSectionAction()
    {
        $em = $this->getDoctrine()
            ->getManager()
            ->getRepository('NewsBundle:News');
        $news = $em->findBy(
            array(),
            array('id' => 'DESC'),
            100,
            0
        );
        return $this->render('NewsBundle:Default:index.html.twig',array('news' => $news));
    }

        public function NewsAction(News $news)
    {
        return $this->render('NewsBundle:Default:news.html.twig',array('news' => $news));
    }
}