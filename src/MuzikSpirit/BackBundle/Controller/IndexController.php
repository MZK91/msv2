<?php

namespace MuzikSpirit\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class MainController
 * @package MuzikSpirit\BackBundle\Controller
 */
class IndexController extends Controller
{
    /**
     * Function pour l'index du site
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('MuzikSpiritBackBundle:Article')->getArticleLimit(30);


        //exit(dump($article));

        return $this->render('MuzikSpiritBackBundle:Main:index.html.twig', array(
            'article' => $article,
        ));
    }
}
