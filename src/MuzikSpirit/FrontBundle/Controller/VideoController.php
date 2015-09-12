<?php

namespace MuzikSpirit\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use MuzikSpirit\BackBundle\Entity\Video;

/**
 * Class VideoController
 * @package MuzikSpirit\FrontBundle\Controller
 */
class VideoController extends Controller
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
            $query = $em->getRepository('MuzikSpiritBackBundle:Video')->getListVideoQuery()->getQuery();
        } else {
            $query = $em->getRepository('MuzikSpiritBackBundle:Video')->getListVideoBySectionQuery($sectionID)->getQuery();
        }
        $paginator  = $this->get('knp_paginator');
        $paginator = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render(
            'MuzikSpiritFrontBundle:Video:list.html.twig',
            [
                'page' => $page,
                'pagination' => $paginator,
            ]
        );
    }

    /**
     * Affichage de l'article
     *
     * @param Video $video
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction(Video $video)
    {
        return $this->render('MuzikSpiritFrontBundle:Video:view.html.twig', ['video' => $video]);
    }
}
