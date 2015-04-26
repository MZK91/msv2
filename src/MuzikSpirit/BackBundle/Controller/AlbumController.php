<?php

namespace MuzikSpirit\BackBundle\Controller;

use MuzikSpirit\BackBundle\Entity\Album;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AlbumController extends Controller
{
    public function listAction($page)
    {

        $limit = $this->container->getParameter('max_articles');

        $em = $this->getDoctrine()->getManager();

        $dql   = "SELECT album FROM MuzikSpiritBackBundle:Album album ORDER BY album.id DESC";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $paginator = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render('MuzikSpiritBackBundle:Album:list.html.twig',
            array(
                'titre' => 'Album',
                'page' => $page,
                'pagination' => $paginator
            )
        );
    }

    /**
     * SUPPRESSION
     * @param Album $album
     * @return RedirectResponse
     */
    public function removeAction(Album $album){
        $em = $this->getDoctrine()->getManager();
        $em->remove($album);
        $em->flush();
        return $this->redirectToRoute('muzikspirit_back_album_list');
    }
}