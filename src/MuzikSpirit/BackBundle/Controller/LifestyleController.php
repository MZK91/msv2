<?php

namespace MuzikSpirit\BackBundle\Controller;

use MuzikSpirit\BackBundle\Entity\Lifestyle;
use MuzikSpirit\BackBundle\Form\LifestyleType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MuzikSpirit\BackBundle\Utilities\Slug;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class LifestyleController extends Controller
{
    public function listAction($page)
    {

        $limit = $this->container->getParameter('max_articles');

        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('MuzikSpiritBackBundle:Lifestyle')->getListLifestyleQuery()->getQuery();

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
     * Forward des requetes de recherche pour les lister dans la vue de liste
     * @param Request $request
     * @return RedirectResponse
     */
    public function searchForwardAction(Request $request){
        if($request->isMethod('POST') === TRUE)
            $find = $request->request->get('find');

        return new RedirectResponse($this->generateUrl('muzikspirit_back_lifestyle_search',
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
        $query = $em->getRepository('MuzikSpiritBackBundle:Lifestyle')->searchLifestyleQuery($find)->getQuery();

        $paginator  = $this->get('knp_paginator');
        $paginator = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render('MuzikSpiritBackBundle:Lifestyle:list.html.twig',
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
        $lifestyle = new Lifestyle();

        // On récupére le type de l'article et on initialise la section par défaut
        // 1 news 2 video 3 clip 4 son 5 album 6 artiste 7 lyrics 8 lifestyle
        $typeArticle = $em->getRepository('MuzikSpiritBackBundle:TypeArticle')->find(8);

        $form = $this->createForm(new LifestyleType(), $lifestyle,
            array(
                'attr' => array(
                    'method' => 'post',
                    'action' => $this->generateUrl('muzikspirit_back_lifestyle_add')
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

            return $this->redirect($this->generateUrl('muzikspirit_back_lifestyle_add'));
        }

        return $this->render('MuzikSpiritBackBundle:Lifestyle:add_edit.html.twig',array(
                'form'      =>  $form->createView(),
                'titre'     =>  "Ajout de Lifestyle",
            )
        );
    }

    /**
     * EDITION des articles
     * @param Lifestyle $lifestyle
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */
    public function editAction(Request $request, Lifestyle $lifestyle)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new LifestyleType(), $lifestyle,
            array(
                'attr' => array(
                    'method' => 'post',
                    'action' => $this->generateUrl('muzikspirit_back_lifestyle_edit',
                        array(
                            'id' => $lifestyle->getId()
                        )
                    )
                )
            )
        );
        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            $lifestyle->setSlug(Slug::slug($lifestyle->getTitre()));
            $em->persist($data);
            // On met à jour la table article
            $article = $em->getRepository('MuzikSpiritBackBundle:Article')->getArticle($lifestyle->getId(),$lifestyle->getTypeArticle());
            $article->setTitre($lifestyle->getTitre());
            $article->setSlug($lifestyle->getSlug());


            $em->persist($article);
            $em->flush();

            return $this->redirect($this->generateUrl('muzikspirit_back_lifestyle_edit', array('id'=> $lifestyle->getId())));
        }

        return $this->render('MuzikSpiritBackBundle:Lifestyle:add_edit.html.twig',array(
                'form'      =>  $form->createView(),
                'titre'     =>  "Edition de Lifestyle",
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