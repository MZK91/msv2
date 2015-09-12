<?php

namespace MuzikSpirit\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use MuzikSpirit\BackBundle\Entity\Lyrics;

/**
 * Class LyricsController
 * @package MuzikSpirit\FrontBundle\Controller
 */
class LyricsController extends Controller
{

    /**
     * @param int $page
     * @param int $section
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction($page, $section)
    {
        $limit = $this->container->getParameter('max_articles');
        $tabSectionUrl = $this->container->getParameter('sections_url');
        $sectionID = $tabSectionUrl[$section];

        $em = $this->getDoctrine()->getManager();

        if ($sectionID == 0) {
            $query = $em->getRepository('MuzikSpiritBackBundle:Lyrics')->getListLyricsQuery()->getQuery();
        } else {
            $query = $em->getRepository('MuzikSpiritBackBundle:Lyrics')->getListLyricsBySectionQuery($sectionID)->getQuery();
        }
        $paginator  = $this->get('knp_paginator');
        $paginator = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render(
            'MuzikSpiritFrontBundle:Lyrics:list.html.twig',
            [
                'page' => $page,
                'pagination' => $paginator,
            ]
        );
    }

    /**
     * Affichage de l'article
     *
     * @param Lyrics $lyrics
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction(Lyrics $lyrics)
    {
        return $this->render('MuzikSpiritFrontBundle:Lyrics:view.html.twig', ['lyrics' => $lyrics]);
    }
}
