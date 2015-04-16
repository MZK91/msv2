<?php

namespace MuzikSpirit\BackBundle\Controller;

use MuzikSpirit\BackBundle\Utilities\Slug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MuzikSpirit\BackBundle\Entity\News;
use MuzikSpirit\BackBundle\Form\NewsType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class NewsController extends Controller
{
    /**
     * Affichage de la Top Barre de navigation avec action pour le formulaire de recherche
     * @param $action
     * @param null $find
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function topNavAction($action,$find = NULL){
        return $this->render('MuzikSpiritBackBundle:Partial:top_navigation.html.twig',
            array(
                'action'=> $action,
                'find'  => $find
            )
        );
    }

    /**
     * Affichage de la liste des news
     * @param $page
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function listAction($page)
    {

        $limit = $this->container->getParameter('max_articles');

        $em = $this->getDoctrine()->getManager();

        $dql   = "SELECT n FROM MuzikSpiritBackBundle:News n ORDER BY n.id DESC";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $paginator = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render('MuzikSpiritBackBundle:News:list.html.twig',
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
            $find = $request->request->get('find', "booba");


        return new RedirectResponse($this->generateUrl('muzikspirit_back_news_search',
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

        $dql   = "SELECT news FROM MuzikSpiritBackBundle:News AS news WHERE news.titre LIKE :find ORDER BY news.id DESC";
        $query = $em->createQuery($dql);
        $query->setParameter('find', '%'.$find.'%');

        $paginator  = $this->get('knp_paginator');
        $paginator = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render('MuzikSpiritBackBundle:News:list.html.twig',
            array(
                'titre'=> "Résultat de la recherche ".$find." dans les News.",
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
        // Création d'un nouvel objet News
        $news = new News();


        // On défini le type de l'article
        $em = $this->getDoctrine()->getManager();
        $typeArticle = $em->getRepository('MuzikSpiritBackBundle:TypeArticle')->find(3);
        $section = $em->getRepository('MuzikSpiritBackBundle:Section')->find(1);
        $news->setSection($section);


        // Création du formulaire
        $form = $this->createForm(new NewsType(), $news);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $data = $form->getData();

            // On récupére le titre soumis pour le sluggifié
            $titre = $form['titre']->getData();
            $titre = Slug::slug($titre);
            $data->setSlug($titre);

            $data->setTypeArticle($typeArticle);

            $em->persist($data);
            $em->flush();

            return $this->redirect($this->generateUrl('muzikspirit_back_news_add'));
        }

        return $this->render('MuzikSpiritBackBundle:News:add_edit.html.twig',array(
                'form'      =>  $form->createView(),
                'id'        =>  0,
                'action'    =>  "Add",
                'titre'     =>  "Ajout de News",
            )
        );
    }

    /**
     * EDITION des articles
     * @param News $news
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, News $news)
    {

        $em = $this->getDoctrine()->getManager();
        // Création du formulaire
        $form = $this->createForm(new NewsType(), $news);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $data = $form->getData();

            // On récupére le titre soumis pour le sluggifié
            $titre = $form['titre']->getData();
            $titre = Slug::slug($titre);
            $data->setSlug($titre);

            $em->persist($data);
            $em->flush();

            return $this->redirect($this->generateUrl('muzikspirit_back_news_edit', array('id'=> $news->getId())));
        }

        return $this->render('MuzikSpiritBackBundle:News:add_edit.html.twig',array(
                'form'      =>  $form->createView(),
                'id'        =>  0,
                'action'    =>  "Edit",
                'titre'     =>  "Edition de News",
            )
        );
    }

    public function newsAction(News $news)
    {
        return $this->render('NewsBundle:Default:news.html.twig',array('news' => $news));
    }

    /**
     * SUPPRESSION
     * @param News $news
     * @return RedirectResponse
     */
    public function removeAction(News $news){
            $em = $this->getDoctrine()->getManager();
            $em->remove($news);
            $em->flush();
            return $this->redirectToRoute('muzikspirit_back_news_list');
    }
}