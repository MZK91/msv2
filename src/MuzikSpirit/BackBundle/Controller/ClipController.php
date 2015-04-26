<?php

namespace MuzikSpirit\BackBundle\Controller;

use MuzikSpirit\BackBundle\Entity\Clip;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ClipController extends Controller
{
    public function listAction($page)
    {

        $limit = $this->container->getParameter('max_articles');

        $em = $this->getDoctrine()->getManager();

        $dql   = "SELECT clip FROM MuzikSpiritBackBundle:Clip clip ORDER BY clip.id DESC";
        $query = $em->createQuery($dql);

        //$query = $em->getRepository('MuzikSpiritBackBundle:Clip')->getListClip();

        $paginator  = $this->get('knp_paginator');
        $paginator = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render('MuzikSpiritBackBundle:Clip:list.html.twig',
            array(
                'titre'=>'News',
                'page' => $page,
                'pagination' => $paginator
            )
        );
    }

    /**
     * SUPPRESSION
     * @param Clip $clip
     * @return RedirectResponse
     */
    public function removeAction(Clip $clip){
        $em = $this->getDoctrine()->getManager();
        $em->remove($clip);
        $em->flush();
        return $this->redirectToRoute('muzikspirit_back_clip_list');
    }
}