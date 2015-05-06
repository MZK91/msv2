<?php

namespace MuzikSpirit\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        //$this->get('muzikspirit_back.notification')->notify('test');


        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('MuzikSpiritBackBundle:Article')->getArticleLimit(30);

        //exit(dump($article));

        return $this->render('MuzikSpiritBackBundle:Main:index.html.twig', array(
            'article' => $article,
        ));
    }
}
