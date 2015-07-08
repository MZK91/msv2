<?php

namespace MuzikSpirit\BackBundle\Controller;

use MuzikSpirit\BackBundle\Entity\Clip;
use MuzikSpirit\BackBundle\Entity\Lyrics;
use MuzikSpirit\BackBundle\Form\ClipType;

use MuzikSpirit\BackBundle\Utilities\Slug;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class ClipController
 * @package MuzikSpirit\BackBundle\Controller
 */
class ClipController extends Controller
{
    /**
     * @param int $page
     * @return \Symfony\Component\HttpFoundation\Response
     * Listing des clips
     */
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

        return $this->render(
            'MuzikSpiritBackBundle:Clip:list.html.twig',
            [
                'titre'=>'Clips',
                'page' => $page,
                'pagination' => $paginator,
            ]
        );
    }

    /**
     * Forward des requetes de recherche pour les lister dans la vue de liste
     * @param Request $request
     * @return RedirectResponse
     */
    public function searchForwardAction(Request $request)
    {
        if ($request->isMethod('POST') === true) {
            $find = $request->request->get('find');
        }

        return new RedirectResponse(
            $this->generateUrl('muzikspirit_back_clip_search',
            [
                'find' => $find,
                'page' => 1,
            ]
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
    public function addAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $clip = new Clip();

        // On récupére le type de l'article et on initialise la section par défaut
        // 1 news 2 video 3 clip 4 son 5 album 6 artiste 7 lyrics 8 lifestyle
        $typeArticle = $em->getRepository('MuzikSpiritBackBundle:TypeArticle')->find(3);
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

            // Ajout d'un article Lyrics basé sur le clip tout juste publié
            $lyrics = new Lyrics();
            if($em->getRepository('MuzikSpiritBackBundle:Lyrics')->getLyricsTitleCount($clip->getTitre()) == 0) {
                $typeArticle = $em->getRepository('MuzikSpiritBackBundle:TypeArticle')->find(7);
                $lyrics->setTitre($clip->getTitre());
                $lyrics->setArtiste($clip->getArtiste());
                $lyrics->setSon($clip->getSon());
                $lyrics->setFeaturing($clip->getFeaturing());
                $lyrics->setSection($clip->getSection());
                $lyrics->setSlug($clip->getSlug());
                $lyrics->setImage($clip->getImage());
                $lyrics->setTypeArticle($typeArticle);
                $lyrics->setVide(1);
                $em->persist($lyrics);
                $em->flush();
            }

            return $this->redirect($this->generateUrl('muzikspirit_back_clip_add'));
        }

        return $this->render('MuzikSpiritBackBundle:Clip:add_edit.html.twig',array(
                'form'      =>  $form->createView(),
                'titre'     =>  "Ajout de Clip",
            )
        );
    }

    /**
     * EDITION des articles
     * @param News $news
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */
    public function editAction(Request $request, Clip $clip)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new ClipType(), $clip,
            array(
                'attr' => array(
                    'method' => 'post',
                    'action' => $this->generateUrl('muzikspirit_back_clip_edit',
                        array(
                            'id' => $clip->getId()
                        )
                    )
                )
            )
        );
        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            $clip->setSlug(Slug::slug($clip->getTitre()));
            $em->persist($data);
            // On met à jour la table article
            $article = $em->getRepository('MuzikSpiritBackBundle:Article')->getArticle($clip->getId(),$clip->getTypeArticle());
            $article->setTitre($clip->getTitre());
            $article->setSlug($clip->getSlug());
            $em->persist($article);
            $em->flush();

            return $this->redirect($this->generateUrl('muzikspirit_back_clip_edit', array('id'=> $clip->getId())));
        }

        return $this->render('MuzikSpiritBackBundle:Clip:add_edit.html.twig',array(
                'form'      =>  $form->createView(),
                'titre'     =>  "Edition de Clip",
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