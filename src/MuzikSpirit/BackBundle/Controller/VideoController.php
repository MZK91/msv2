<?php

namespace MuzikSpirit\BackBundle\Controller;

use MuzikSpirit\BackBundle\Entity\Video;
use MuzikSpirit\BackBundle\Form\VideoType;
use MuzikSpirit\BackBundle\Utilities\Slug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class VideoController extends Controller
{
    public function listAction($page)
    {

        $limit = $this->container->getParameter('max_articles');

        $em = $this->getDoctrine()->getManager();

        $query = $em->getRepository('MuzikSpiritBackBundle:Video')->getListVideoQuery()->getQuery();

        $paginator  = $this->get('knp_paginator');
        $paginator = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render('MuzikSpiritBackBundle:Video:list.html.twig',
            array(
                'titre' => 'Video',
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

        return new RedirectResponse($this->generateUrl('muzikspirit_back_video_search',
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
        $query = $em->getRepository('MuzikSpiritBackBundle:Video')->searchVideoQuery($find)->getQuery();

        $paginator  = $this->get('knp_paginator');
        $paginator = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render('MuzikSpiritBackBundle:Video:list.html.twig',
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
        $video = new Video();

        // On récupére le type de l'article et on initialise la section par défaut
        // 1 news 2 video 3 clip 4 son 5 album 6 artiste 7 lyrics 8 lifestyle
        $typeArticle = $em->getRepository('MuzikSpiritBackBundle:TypeArticle')->find(2);
        $section = $em->getRepository('MuzikSpiritBackBundle:Section')->find(1);
        $video->setSection($section);

        $form = $this->createForm(new VideoType(), $video,
            array(
                'attr' => array(
                    'method' => 'post',
                    'action' => $this->generateUrl('muzikspirit_back_video_add')
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

            return $this->redirect($this->generateUrl('muzikspirit_back_video_add'));
        }

        return $this->render('MuzikSpiritBackBundle:Video:add_edit.html.twig',array(
                'form'      =>  $form->createView(),
                'titre'     =>  "Ajout de Video",
            )
        );
    }

    /**
     * EDITION des articles
     * @param News $news
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */
    public function editAction(Request $request, Video $video)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new VideoType(), $video,
            array(
                'attr' => array(
                    'method' => 'post',
                    'action' => $this->generateUrl('muzikspirit_back_video_edit',
                        array(
                            'id' => $video->getId()
                        )
                    )
                )
            )
        );
        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            $video->setSlug(Slug::slug($video->getTitre()));
            $em->persist($data);
            // On met à jour la table article
            $article = $em->getRepository('MuzikSpiritBackBundle:Article')->getArticle($video->getId(),$video->getTypeArticle());
            $article->setTitre($video->getTitre());
            $article->setSlug($video->getSlug());
            $em->persist($article);
            $em->flush();

            return $this->redirect($this->generateUrl('muzikspirit_back_video_edit', array('id'=> $video->getId())));
        }

        return $this->render('MuzikSpiritBackBundle:Video:add_edit.html.twig',array(
                'form'      =>  $form->createView(),
                'titre'     =>  "Edition de Video",
            )
        );
    }

    /**
     * SUPPRESSION
     * @param Video $video
     * @return RedirectResponse
     */
    public function removeAction(Video $video){
        $em = $this->getDoctrine()->getManager();
        $em->remove($video);
        $em->flush();
        return $this->redirectToRoute('muzikspirit_back_video_list');
    }
}