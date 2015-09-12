<?php

namespace MuzikSpirit\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use MuzikSpirit\BackBundle\Entity\Album;

/**
 * Class AlbumController
 * @package MuzikSpirit\FrontBundle\Controller
 */
class AlbumController extends Controller
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
            $query = $em->getRepository('MuzikSpiritBackBundle:Album')->getListAlbumQuery()->getQuery();
        } else {
            $query = $em->getRepository('MuzikSpiritBackBundle:Album')->getListAlbumBySectionQuery($sectionID)->getQuery();
        }
        $paginator  = $this->get('knp_paginator');
        $paginator = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render(
            'MuzikSpiritFrontBundle:Album:list.html.twig',
            [
                'page' => $page,
                'pagination' => $paginator,
            ]
        );
    }

    /**
     * Affichage de l'article
     *
     * @param Album $album
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction(Album $album)
    {
        return $this->render('MuzikSpiritFrontBundle:Album:view.html.twig', ['album' => $album]);
    }
}
