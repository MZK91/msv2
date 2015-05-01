<?php

namespace MuzikSpirit\BackBundle\Controller;

use MuzikSpirit\BackBundle\Entity\Clip;
use MuzikSpirit\BackBundle\Form\ClipType;

use MuzikSpirit\BackBundle\Entity\Section;
use MuzikSpirit\BackBundle\Utilities\Slug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ClipController extends Controller
{
    public function listAction($page)
    {

        $limit = $this->container->getParameter('max_articles');

        $em = $this->getDoctrine()->getManager();

        $query = $em->getRepository('MuzikSpiritBackBundle:Clip')->getListClipQuery()->getQuery();

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
     * Forward des requetes de recherche pour les lister dans la vue de liste
     * @param Request $request
     * @return RedirectResponse
     */
    public function searchForwardAction(Request $request){

        if($request->isMethod('POST') === TRUE)
            $find = $request->request->get('find');

        return new RedirectResponse($this->generateUrl('muzikspirit_back_clip_search',
            array(
                'find' => $find,
                'page' => 1,
            )
        )
        );
    }

    /**
     * Traitement des recherches
     * @param $find
     * @param $page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchAction($find,$page)
    {
        $limit = $this->container->getParameter('max_articles');
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('MuzikSpiritBackBundle:Clip')->searchClipQuery($find)->getQuery();

        $paginator  = $this->get('knp_paginator');
        $paginator = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render('MuzikSpiritBackBundle:Clip:list.html.twig',
            array(
                'titre'=> "Résultat de la recherche : ".$find."",
                'page' => $page,
                'pagination' => $paginator,
                'find' => $find

            )
        );
    }

    /**
     * AJOUT de nouveaux articles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $clip = new Clip();
        $section = new Section();

        $typeArticle = $em->getRepository('MuzikSpiritBackBundle:TypeArticle')->find(1);
        $section = $em->getRepository('MuzikSpiritBackBundle:Section')->find(1);
        $clip->setSection($section);

        $form = $this->createForm(new ClipType(), $clip,
            array(
                'attr' => array(
                    'method' => 'post',
                    'action' => $this->generateUrl('muzikspirit_back_clip_add')
                    // Action du formulaire pointe vers cette même action de controlleur
                )
            )
        );

        $form->handleRequest($request);

        if ($form->isValid()) {

            $data = $form->getData();
            $data->setTypeArticle($typeArticle);
            $em->persist($data);
            $em->flush();

            return $this->redirect($this->generateUrl('muzikspirit_back_clip_add'));
        }

        return $this->render('MuzikSpiritBackBundle:Clip:add_edit.html.twig',array(
                'form'      =>  $form->createView(),
                'titre'     =>  "Ajout de Clip",
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