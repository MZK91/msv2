<?php

namespace MuzikSpirit\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use MuzikSpirit\BackBundle\Entity\Clip;

/**
 * Class ClipController
 * @package MuzikSpirit\FrontBundle\Controller
 */
class ClipController extends Controller
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
            $query = $em->getRepository('MuzikSpiritBackBundle:Clip')->getListClipQuery()->getQuery();
        } else {
            $query = $em->getRepository('MuzikSpiritBackBundle:Clip')->getListClipBySectionQuery($sectionID)->getQuery();
        }
        $paginator  = $this->get('knp_paginator');
        $paginator = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render(
            'MuzikSpiritFrontBundle:Clip:list.html.twig',
            [
                'page' => $page,
                'pagination' => $paginator,
            ]
        );
    }

    /**
     * Affichage de l'article
     *
     * @param Clip $clip
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction(Clip $clip)
    {
        return $this->render('MuzikSpiritFrontBundle:Clip:view.html.twig', ['clip' => $clip]);
    }
}
