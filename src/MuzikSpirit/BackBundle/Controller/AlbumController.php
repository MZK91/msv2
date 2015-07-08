<?php

namespace MuzikSpirit\BackBundle\Controller;

use MuzikSpirit\BackBundle\Entity\Album;
use MuzikSpirit\BackBundle\Form\AlbumType;

use MuzikSpirit\BackBundle\Utilities\Slug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class AlbumController extends Controller
{
    /**
     * Affichage de la liste des album
     * @param $page
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function listAction($page)
    {
        /**
         * On récupére la limite du nombre d'article maximum à afficher.
         * Défini dans le fichier config.yml -> parameters
         */
        $limit = $this->container->getParameter('max_articles');
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('MuzikSpiritBackBundle:Album')->getListAlbumQuery()->getQuery();

        $paginator  = $this->get('knp_paginator');
        $paginator = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render('MuzikSpiritBackBundle:Album:list.html.twig',
            array(
                'titre'=>'Album',
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

        return new RedirectResponse($this->generateUrl('muzikspirit_back_album_search',
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
        $query = $em->getRepository('MuzikSpiritBackBundle:Album')->searchAlbumQuery($find)->getQuery();

        $paginator  = $this->get('knp_paginator');
        $paginator = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render('MuzikSpiritBackBundle:Album:list.html.twig',
            array(
                'titre'=> "Résultat de la recherche ".$find." dans les Album.",
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
        // Création d'un nouvel objet Album
        $album = new Album();

        // On défini le type de l'article
        $em = $this->getDoctrine()->getManager();
        // 1 news 2 video 3 clip 4 son 5 album 6 artiste 7 lyrics 8 lifestyle
        $typeArticle = $em->getRepository('MuzikSpiritBackBundle:TypeArticle')->find(5);
        $section = $em->getRepository('MuzikSpiritBackBundle:Section')->find(1);
        $album->setSection($section);


        // Création du formulaire
        $form = $this->createForm(
            new AlbumType(),
            $album,
            [
                'attr' => [
                    'method' => 'post',
                    'action' => $this->generateUrl('muzikspirit_back_album_add')
                    // Action du formulaire pointe vers cette même action de controlleur
                ],
            ]
        );

        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            $data->setTypeArticle($typeArticle);
            $em->persist($data);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success',
                array(
                    'facebook' => 'facebook',
                    'twitter'  => 'twitter',
                )
            );

            return $this->redirect($this->generateUrl('muzikspirit_back_album_add'));
        }

        return $this->render(
            'MuzikSpiritBackBundle:Album:add_edit.html.twig',
            array(
                'form'      =>  $form->createView(),
                'action'    =>  "Add",
                'titre'     =>  "Ajout de Album",
            )
        );
    }

    /**
     * EDITION des articles
     * @param Album $album
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */
    public function editAction(Request $request, Album $album)
    {
        $em = $this->getDoctrine()->getManager();
        // Création du formulaire
        $form = $this->createForm(new AlbumType(), $album,
            array(
                'attr' => array(
                    'method' => 'post',
                    'action' => $this->generateUrl('muzikspirit_back_album_edit',
                        array(
                            'id' => $album->getId()
                        )
                    )
                )
            )
        );
        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            $album->setSlug(Slug::slug($album->getTitre()));
            $em->persist($data);

            // On met à jour la table article
            $article = $em->getRepository('MuzikSpiritBackBundle:Article')->getArticle($album->getId(),$album->getTypeArticle());
            $article->setTitre($album->getTitre());
            $article->setSlug($album->getSlug());
            $em->persist($article);
            $em->flush();


            return $this->redirect($this->generateUrl('muzikspirit_back_album_edit', array('id'=> $album->getId())));
        }

        return $this->render('MuzikSpiritBackBundle:Album:add_edit.html.twig',array(
                'form'      =>  $form->createView(),
                'titre'     =>  "Edition de Album",
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