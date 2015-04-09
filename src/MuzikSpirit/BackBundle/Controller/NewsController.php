<?php

namespace MuzikSpirit\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NewsController extends Controller
{
    public function listAction()
    {
        $em = $this->getDoctrine()
            ->getManager()
            ->getRepository('MuzikSpiritBackBundle:News');
        $news = $em->findBy(
            array(),
            array('id' => 'DESC'),
            100,
            0
        );
        return $this->render('MuzikSpiritBackBundle:News:list.html.twig',array('news' => $news));
    }
/*
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
*/
}