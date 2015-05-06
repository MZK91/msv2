<?php

namespace MuzikSpirit\BackBundle\Controller;

use MuzikSpirit\BackBundle\Entity\Son;
use MuzikSpirit\BackBundle\Form\SonType;

use MuzikSpirit\BackBundle\Entity\Section;
use MuzikSpirit\BackBundle\Utilities\Slug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class SonController extends Controller
{

    public function listAction($page)
    {

        $limit = $this->container->getParameter('max_articles');
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('MuzikSpiritBackBundle:Son')->getListSonQuery()->getQuery();

        $paginator  = $this->get('knp_paginator');
        $paginator = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render('MuzikSpiritBackBundle:Son:list.html.twig',
            array(
                'titre' => 'Son',
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

        return new RedirectResponse($this->generateUrl('muzikspirit_back_son_search',
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
        $query = $em->getRepository('MuzikSpiritBackBundle:Son')->searchSonQuery($find)->getQuery();

        $paginator  = $this->get('knp_paginator');
        $paginator = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render('MuzikSpiritBackBundle:Son:list.html.twig',
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
        $son = new Son();

        // On récupére le type de l'article et on initialise la section par défaut
        // 1 news 2 video 3 clip 4 son 5 album 6 artiste 7 lyrics 8 lifestyle
        $typeArticle = $em->getRepository('MuzikSpiritBackBundle:TypeArticle')->find(4);
        $section = $em->getRepository('MuzikSpiritBackBundle:Section')->find(1);
        $son->setSection($section);

        $form = $this->createForm(new SonType(), $son,
            array(
                'attr' => array(
                    'method' => 'post',
                    'action' => $this->generateUrl('muzikspirit_back_son_add')
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

            return $this->redirect($this->generateUrl('muzikspirit_back_son_add'));
        }

        return $this->render('MuzikSpiritBackBundle:Son:add_edit.html.twig',array(
                'form'      =>  $form->createView(),
                'titre'     =>  "Ajout de Son",
            )
        );
    }

    /**
     * EDITION des articles
     * @param Son $son
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */
    public function editAction(Request $request, Son $son)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new SonType(), $son,
            array(
                'attr' => array(
                    'method' => 'post',
                    'action' => $this->generateUrl('muzikspirit_back_son_edit',
                        array(
                            'id' => $son->getId()
                        )
                    )
                )
            )
        );
        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            $son->setSlug(Slug::slug($son->getTitre()));
            $em->persist($data);
            // On met à jour la table article
            $article = $em->getRepository('MuzikSpiritBackBundle:Article')->getArticle($son->getId(),$son->getTypeArticle());
            $article->setTitre($son->getTitre());
            $article->setSlug($son->getSlug());


            $em->persist($article);
            $em->flush();

            return $this->redirect($this->generateUrl('muzikspirit_back_son_edit', array('id'=> $son->getId())));
        }

        return $this->render('MuzikSpiritBackBundle:Son:add_edit.html.twig',array(
                'form'      =>  $form->createView(),
                'titre'     =>  "Edition de Son",
            )
        );
    }

    /**
     * SUPPRESSION
     * @param Son $son
     * @return RedirectResponse
     */
    public function removeAction(Son $son){
        $em = $this->getDoctrine()->getManager();
        $em->remove($son);
        $em->flush();
        return $this->redirectToRoute('muzikspirit_back_son_list');
    }
}