<?php

namespace MuzikSpirit\BackBundle\Controller;

use MuzikSpirit\BackBundle\Entity\Carousel;
use MuzikSpirit\BackBundle\Form\CarouselType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CarouselController
 * @package MuzikSpirit\BackBundle\Controller
 */
class CarouselController extends Controller
{
    /**
     * Listing des Images du carousel
     * @param int $page page en cours
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction($page)
    {
        $limit = $this->container->getParameter('max_articles');
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('MuzikSpiritBackBundle:Carousel')->getListCarouselQuery()->getQuery();

        $paginator = $this->get('knp_paginator');
        $paginator = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        return $this->render(
            'MuzikSpiritBackBundle:Carousel:list.html.twig',
            [
                'titre' => 'Carousel',
                'page' => $page,
                'pagination' => $paginator,
            ]
        );
    }

    /**
     * AJOUT d'un nouvel élément au Carousel
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {
        $carousel = new Carousel();

        if ($request->query->get('titre')) {
            $titre = $request->query->get('titre');
        } else {
            $titre = '';
        }
        $carousel->setTitre($titre);

        if ($request->query->get('type') and is_numeric($request->query->get('type'))) {
            $type = $request->query->get('type');
        } else {
            $type = 1;
        }
        $carousel->setTitre($titre);

        if ($request->query->get('section') and is_numeric($request->query->get('section'))) {
            $section = $request->query->get('section');
        } else {
            $section = 1;
        }
        $carousel->setTitre($titre);

        if ($request->query->get('lien')) {
            $lien = $request->query->get('lien');
        } else {
            $lien = '';
        }
        $carousel->setLien($lien);

        // On défini le type de l'article
        $em = $this->getDoctrine()->getManager();
        // 1 news 2 video 3 clip 4 son 5 album 6 artiste 7 lyrics 8 lifestyle
        $typeArticle = $em->getRepository('MuzikSpiritBackBundle:TypeArticle')->find($type);
        $section = $em->getRepository('MuzikSpiritBackBundle:Section')->find($section);

        $carousel->setSection($section);
        $carousel->setTypeArticle($typeArticle);

        // Création du formulaire
        $form = $this->createForm(
            new CarouselType(),
            $carousel,
            [
                'attr' => [
                    'method' => 'post',
                    'action' => $this->generateUrl('muzikspirit_back_carousel_add'), // Action du formulaire pointe vers cette même action de controlleur
                ],
            ]
        );

        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            $idImage = $form->get('id_image')->getData();
            $image = $em->getRepository('MuzikSpiritBackBundle:Image')->find($idImage);

            $data->setImage($image);
            $data->setTypeArticle($typeArticle);
            $em->persist($data);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'OK');

            return $this->redirect($this->generateUrl('muzikspirit_back_carousel_add'));
        }

        return $this->render(
            'MuzikSpiritBackBundle:Carousel:add_edit.html.twig',
            [
                'form'      =>  $form->createView(),
                'action'    =>  "Add",
                'titre'     =>  "Ajout Carousel",
            ]
        );
    }

    /**
     * SUPPRESSION
     * @param Carousel $carousel
     * @return RedirectResponse
     */
    public function removeAction(Carousel $carousel)
    {
        $this->forward('muzikspirit_back_image_remove:removeAction', ['id' => $carousel->getImage()]);

        $em = $this->getDoctrine()->getManager();
        $em->remove($carousel);
        $em->flush();



        return $this->redirectToRoute('muzikspirit_back_carousel_list');
    }
}
