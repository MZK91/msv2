<?php

namespace MuzikSpirit\BackBundle\Controller;

use MuzikSpirit\BackBundle\Entity\Artiste;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MuzikSpirit\BackBundle\Form\ArtisteType;

use MuzikSpirit\BackBundle\Utilities\Slug;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ArtisteController extends Controller
{
    public function listAction($page)
    {

        $limit = $this->container->getParameter('max_articles');

        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('MuzikSpiritBackBundle:Artiste')->getListArtisteQuery()->getQuery();

        $paginator  = $this->get('knp_paginator');
        $paginator = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render('MuzikSpiritBackBundle:Artiste:list.html.twig',
            array(
                'titre' => 'Artiste',
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

        return new RedirectResponse($this->generateUrl('muzikspirit_back_artiste_search',
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
        $query = $em->getRepository('MuzikSpiritBackBundle:Artiste')->searchArtisteQuery($find)->getQuery();

        $paginator  = $this->get('knp_paginator');
        $paginator = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render('MuzikSpiritBackBundle:Artiste:list.html.twig',
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
    public function addAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $artiste = new Artiste();

        // On récupére le type de l'article et on initialise la section par défaut
        // 1 news 2 video 3 clip 4 son 5 album 6 artiste 7 lyrics 8 lifestyle
        $typeArticle = $em->getRepository('MuzikSpiritBackBundle:TypeArticle')->find(6);
        $section = $em->getRepository('MuzikSpiritBackBundle:Section')->find(1);
        $artiste->setSection($section);

        $form = $this->createForm(new ArtisteType(), $artiste,
            array(
                'attr' => array(
                    'method' => 'post',
                    'action' => $this->generateUrl('muzikspirit_back_artiste_add')
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

            return $this->redirect($this->generateUrl('muzikspirit_back_artiste_add'));
        }

        return $this->render('MuzikSpiritBackBundle:Artiste:add_edit.html.twig',array(
                'form'      =>  $form->createView(),
                'titre'     =>  "Ajout de Artiste",
            )
        );
    }

    /**
     * EDITION des articles
     * @param Artiste $artiste
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */
    public function editAction(Request $request, Artiste $artiste)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new ArtisteType(), $artiste,
            array(
                'attr' => array(
                    'method' => 'post',
                    'action' => $this->generateUrl('muzikspirit_back_artiste_edit',
                        array(
                            'id' => $artiste->getId()
                        )
                    )
                )
            )
        );
        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            $artiste->setSlug(Slug::slug($artiste->getTitre()));
            $em->persist($data);
            // On met à jour la table article
            $article = $em->getRepository('MuzikSpiritBackBundle:Article')->getArticle( $artiste->getId(), $artiste->getTypeArticle());
            $article->setTitre($artiste->getTitre());
            $article->setSlug($artiste->getSlug());
            $em->persist($article);
            $em->flush();

            return $this->redirect($this->generateUrl('muzikspirit_back_artiste_edit', array('id'=> $artiste->getId())));
        }

        return $this->render('MuzikSpiritBackBundle:Artiste:add_edit.html.twig',array(
                'form'      =>  $form->createView(),
                'titre'     =>  "Edition de Artiste",
            )
        );
    }

    /**
     * SUPPRESSION
     * @param Artiste $artiste
     * @return RedirectResponse
     */
    public function removeAction(Artiste $artiste){
        $em = $this->getDoctrine()->getManager();
        $em->remove($artiste);
        $em->flush();
        return $this->redirectToRoute('muzikspirit_back_artiste_list');
    }
}