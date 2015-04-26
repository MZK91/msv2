<?php

namespace MuzikSpirit\BackBundle\Controller;

use MuzikSpirit\BackBundle\Entity\Lyrics;
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

    /**
     * SUPPRESSION
     * @param Lyrics $lyrics
     * @return RedirectResponse
     */
    public function removeAction(Lyrics $lyrics){
        $em = $this->getDoctrine()->getManager();
        $em->remove($lyrics);
        $em->flush();
        return $this->redirectToRoute('muzikspirit_back_lyrics_list');
    }
}