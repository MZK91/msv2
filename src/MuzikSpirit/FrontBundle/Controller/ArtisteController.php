<?php

namespace MuzikSpirit\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use MuzikSpirit\BackBundle\Entity\Artiste;

/**
 * Class ArtisteController
 * @package MuzikSpirit\FrontBundle\Controller
 */
class ArtisteController extends Controller
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
            $query = $em->getRepository('MuzikSpiritBackBundle:Artiste')->getListArtisteQuery()->getQuery();
        } else {
            $query = $em->getRepository('MuzikSpiritBackBundle:Artiste')->getListArtisteBySectionQuery($sectionID)->getQuery();
        }
        $paginator  = $this->get('knp_paginator');
        $paginator = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render(
            'MuzikSpiritFrontBundle:Artiste:list.html.twig',
            [
                'page' => $page,
                'pagination' => $paginator,
            ]
        );
    }

    /**
     * Affichage de l'article
     *
     * @param Artiste $artiste
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction(Artiste $artiste)
    {
        return $this->render('MuzikSpiritFrontBundle:Artiste:view.html.twig', ['artiste' => $artiste]);
    }
}
