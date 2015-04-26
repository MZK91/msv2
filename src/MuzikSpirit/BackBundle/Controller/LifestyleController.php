<?php

namespace MuzikSpirit\BackBundle\Controller;

use MuzikSpirit\BackBundle\Entity\Lifestyle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LifestyleController extends Controller
{
    public function listAction($page)
    {

        $limit = $this->container->getParameter('max_articles');

        $em = $this->getDoctrine()->getManager();

        $dql   = "SELECT lifestyle FROM MuzikSpiritBackBundle:Lifestyle lifestyle ORDER BY lifestyle.id DESC";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $paginator = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render('MuzikSpiritBackBundle:Lifestyle:list.html.twig',
            array(
                'titre' => 'Lifestyle',
                'page' => $page,
                'pagination' => $paginator
            )
        );
    }

    /**
     * SUPPRESSION
     * @param Lifestyle $lifestyle
     * @return RedirectResponse
     */
    public function removeAction(Lifestyle $lifestyle){
        $em = $this->getDoctrine()->getManager();
        $em->remove($lifestyle);
        $em->flush();
        return $this->redirectToRoute('muzikspirit_back_lifestyle_list');
    }
}