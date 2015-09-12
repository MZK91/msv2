<?php

namespace MuzikSpirit\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use MuzikSpirit\BackBundle\Entity\Son;

/**
 * Class SonController
 * @package MuzikSpirit\FrontBundle\Controller
 */
class SonController extends Controller
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
            $query = $em->getRepository('MuzikSpiritBackBundle:Son')->getListSonQuery()->getQuery();
        } else {
            $query = $em->getRepository('MuzikSpiritBackBundle:Son')->getListSonBySectionQuery($sectionID)->getQuery();
        }
        $paginator  = $this->get('knp_paginator');
        $paginator = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render(
            'MuzikSpiritFrontBundle:Son:list.html.twig',
            [
                'page' => $page,
                'pagination' => $paginator,
            ]
        );
    }

    /**
     * Affichage de l'article
     *
     * @param Son $son
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction(Son $son)
    {
        return $this->render('MuzikSpiritFrontBundle:Son:view.html.twig', ['son' => $son]);
    }
}
