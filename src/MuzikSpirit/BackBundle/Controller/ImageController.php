<?php

namespace MuzikSpirit\BackBundle\Controller;


use MuzikSpirit\BackBundle\Utilities\Ara;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MuzikSpirit\BackBundle\Form\ImageType;
use MuzikSpirit\BackBundle\Entity\Image;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use MuzikSpirit\BackBundle\Utilities\Slug;
use MuzikSpirit\BackBundle\Utilities\ImagesHandler;

class ImageController extends Controller
{

    public function listAction(Request $request,$page, $type = 0, $iframe = 0)
    {

        $limit = $this->container->getParameter('max_articles');

        $em = $this->getDoctrine()->getManager();

        if ($type == 0) {
            $query = $em->getRepository('MuzikSpiritBackBundle:Image')->getListImageQuery();
        } else {
            $query = $em->getRepository('MuzikSpiritBackBundle:Image')->getListImageByTypeQuery($type);
        }
        $paginator  = $this->get('knp_paginator');
        $paginator = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        if ($request->query->get('action')) {
            $action = $request->query->get('action');
        } else {
            $action = '';
        }

        if ($iframe === 0) {
            return $this->render(
                'MuzikSpiritBackBundle:Image:list.html.twig',
                array(
                    'pagination' => $paginator,
                    'page' => $page,
                    'type' => $type,
                    'titre' => 'Images',
                )
            );
        } else {
            return $this->render(
                'MuzikSpiritBackBundle:Image:iframe_list.html.twig',
                array(
                    'pagination' => $paginator,
                    'page' => $page,
                    'type' => $type,
                    'iframe' => 1,
                    'action' => $action,
                    'titre' => 'Images',
                )
            );
        }
    }

    /**
     * Forward des requetes de recherche pour les lister dans la vue de liste
     * @param Request $request
     * @return RedirectResponse
     */
    public function searchForwardAction(Request $request)
    {

        if ($request->isMethod('POST') === true) {
            $find = $request->request->get('find', "booba");
            $iframe = $request->request->get('iframe');
            $type = $request->request->get('type');
        }

        return new RedirectResponse(
            $this->generateUrl(
                'muzikspirit_back_image_search',
                array(
                    'find' => $find,
                    'iframe'=> $iframe,
                    'type' => $type,
                    'page' => 1,
                )
            )
        );

    }

    /**
     * Fonction de recherche
     * @param string $find      terme de recherche
     * @param int $page         page en cours
     * @param int $type         type d'image
     * @param int $iframe       fenetre dans une iframe ou pas
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchAction($find, $page, $type = 0, $iframe = 0)
    {
        $limit = $this->container->getParameter('max_articles');

        $em = $this->getDoctrine()->getManager();

        if ($type == 0) {
            $query = $em->getRepository('MuzikSpiritBackBundle:Image')->searchImageQuery($find);
        } else {
            $query = $em->getRepository('MuzikSpiritBackBundle:Image')->searchImageByTypeQuery($find, $type);
        }

        $paginator  = $this->get('knp_paginator');
        $paginator = $paginator->paginate(
            $query,
            $page,
            $limit
        );


        if ($iframe === 0) {
            return $this->render(
                'MuzikSpiritBackBundle:Image:list.html.twig',
                array(
                    'titre' => "Résultat de la recherche " . $find . " dans les News.",
                    'page' => $page,
                    'type' => $type,
                    'iframe' => $iframe,
                    'pagination' => $paginator,
                    'find' => $find

                )
            );
        } else {
            return $this->render(
                'MuzikSpiritBackBundle:Image:iframe_list.html.twig',
                array(
                    'titre' => "Résultat de la recherche ".$find." dans les News.",
                    'page' => $page,
                    'type' => $type,
                    'iframe' => $iframe,
                    'pagination' => $paginator,
                    'find' => $find

                )
            );
        }
    }

    /**
     * Ajout d'image
     * @param Request $request
     * @param int     $iframe
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request, $iframe = 0, $type = 0)
    {
        $image = new Image();
        $form   = $this->createForm(new ImageType(), $image);
        $em = $this->getDoctrine()->getManager();
        if ($type != 0) {
            $form->remove('typeImage');
            $typeImage = $em->getRepository('MuzikSpiritBackBundle:TypeImage')->getTypeImage($type);
            $image->setTypeImage($typeImage);
        }

        $em = $this->getDoctrine()->getManager();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $typeImage = $image->getTypeImage();
            $crop = $typeImage->getCrop();
            $resize = $typeImage->getResize();
            $path = $typeImage->getPath();
            $width = $typeImage->getWidth();
            $height = $typeImage->getHeight();
            $thumb = $typeImage->getThumb();
            $heightThumb = $typeImage->getHeightThumb();
            $widthThumb = $typeImage->getWidthThumb();




            $image->setFileSlug(Slug::slug($image->getTitre('titre'))); // On génére un nom de fichier propre en fonction du titre
            $em->persist($image);
            $em->flush();
            $image->setImage($image->getFileName());

            if ($resize == 1) {
                // On crée un objet IH avec les nouvelles propriétés
                $imageHandler = new ImagesHandler(array('max_width' => $width, 'max_height' => $height));
                if ($imageHandler->createScaledImage($path, $image->getFileName())) {
                    $em->persist($image);
                    $em->flush();
                    if ($thumb == 1) {
                        $imageHandlerThumb = new ImagesHandler(['max_width' => $widthThumb, 'max_height' => $heightThumb]);
                        $imageHandlerThumb->createScaledImage($path, $image->getFileName(), 1);
                    }
                    if ($iframe == 0) {
                        return $this->redirect($this->generateUrl('muzikspirit_back_image_list'));
                    } else {
                        return $this->redirect($this->generateUrl('muzikspirit_back_image_list', array( 'iframe'=> 1)));
                    }
                }
            }
            if ($crop == 1) {
                $em->persist($image);
                $em->flush();

                if ($iframe == 0) {
                    return $this->redirect(
                        $this->generateUrl(
                            'muzikspirit_back_image_crop',
                            array(
                                'id' => $image->getId(),
                                'iframe' => $iframe,
                            )
                        )
                    );
                } else {
                    return $this->redirect(
                        $this->generateUrl(
                            'muzikspirit_back_image_crop',
                            array(
                                'id' => $image->getId(),
                                'iframe' => 1,
                            )
                        )
                    );
                }
            } else {
                // On bouge l'image uploadée vers son dossier de destination
                rename($image->getRootDir().$image->getFileName(), $image->getRootDir().$path.$image->getFileName());
                $em->persist($image);
                $em->flush();
                if ($thumb == 1) {
                    $imageHandlerThumb = new ImagesHandler(['max_width' => $widthThumb, 'max_height' => $heightThumb]);
                    $imageHandlerThumb->createScaledImage($path, $image->getFileName(), 1);
                }
            }
        }

        if ($iframe == 0) {
            return $this->render(
                'MuzikSpiritBackBundle:Image:add_edit.html.twig',
                array(
                    'form'  => $form->createView(),
                    'id'    => 0,
                    'type'    => $type,
                    'titre' => "Ajout d'image(s)",
                )
            );
        } else {
            return $this->render(
                'MuzikSpiritBackBundle:Image:iframe_add_edit.html.twig',
                array(
                    'form'  => $form->createView(),
                    'id'    => 0,
                    'type'    => $type,
                    'titre' => "Ajout d'image(s)",
                )
            );
        }
    }



    public function cropAction(Image $image, Request $request, $iframe = 0){

        $em = $this->getDoctrine()->getManager();
        $typeImage = $image->getTypeImage();
        $path = $typeImage->getPath();
        $thumb = $typeImage->getThumb();
        $heightThumb = $typeImage->getHeightThumb();
        $widthThumb = $typeImage->getWidthThumb();

        $imagePath = $image->getRootDir().$image->getUploadDir().'/'.$image->getImage();

        list($width, $height) = getimagesize($imagePath);
        $origW = $width;
        $origH = $height;

        $form = $this->createFormBuilder()
            ->add('h','hidden')
            ->add('x', 'hidden')
            ->add('y', 'hidden')
            ->add('w', 'hidden')
            ->add('width', 'hidden', ['data' => $typeImage->getWidth()])
            ->add('height','hidden', ['data' => $typeImage->getHeight()])
            ->add('id', 'hidden', ['data' => $image->getId()])
            ->add('path', 'hidden', array( 'data' => $typeImage->getPath()     ) )
            ->add('filename', 'hidden', array( 'data' => $image->getImage()        ) )
            ->add('envoyer', 'submit')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            //$request->request->get('iframe');
            $data = $form->getData();

            $imageHandler = new ImagesHandler();

            $imageHandler->imageCrop($image->getImage(), $data['x'], $data['y'], $data['w'], $data['h'], $data['width'], $data['height']);
            $imageHandler->moveToDir('images/tmp/'.$image->getImage(), $typeImage->getPath().$image->getImage());
            if ($thumb == 1) {
                $imageHandlerThumb = new ImagesHandler(['max_width' => $widthThumb, 'max_height' => $heightThumb]);
                $imageHandlerThumb->createScaledImage($path, $image->getImage(), 1);
            }
            if ($iframe == 0) {
                return $this->redirect($this->generateUrl('muzikspirit_back_image_list'));
            } else {
                return $this->redirect(
                    $this->generateUrl(
                        'muzikspirit_back_image_list',
                        [
                            'type' => $typeImage,
                            'iframe' => 1,
                        ]
                    )
                );
            }
        }
        if ($iframe == 0) {
            return $this->render('MuzikSpiritBackBundle:Image:crop.html.twig', array(
                'form' => $form->createView(),
                'image' => $image->getImage(),
                'width' => $typeImage->getWidth(),
                'height' => $typeImage->getHeight(),
                'orig_w' => $origW,
                'orig_h' => $origH,
            ));
        } else {
            return $this->render('MuzikSpiritBackBundle:Image:iframe_crop.html.twig', array(
                'form' => $form->createView(),
                'image' => $image->getImage(),
                'width' => $typeImage->getWidth(),
                'height' => $typeImage->getHeight(),
                'orig_w' => $origW,
                'orig_h' => $origH,
            ));
        }
    }

    /**
     * @param Images $image
     * @param null   $iframe
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Images $image, $iframe = null)
    {
        $em = $this->getDoctrine()->getManager();
        /*
        $idTypeImage = $em->getRepository('IngetisImagesBundle:TypeImage')->find($image->getIdTypeImage());
        $image->setIdTypeImage($idTypeImage);
        */
        $form = $this->createForm(new ImagesType(), $image);

        $form->remove('idTypeImage');
        $request = $this->getRequest();
        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $em->persist($data);
                $em->flush();
                if ($image->file != NULL) {

                    $ih = $this->container->get('ingetis_images.ImagesHandler');

                    $imageInfo = $ih->imageInfo($image->getPath());

                    $extension = $image->file->guessExtension();

                    $FileName = $imageInfo['fileName'].'.'.$image->file->guessExtension();

                    $ih->moveToTmp($image->file,$FileName);

                    if($imageInfo['extension'] != $extension){
                        $ih->imageConverter('images/tmp/',$FileName,$imageInfo['extension']);
                    }
                    //Poser la question Lundi à Julien

                    // On récupére les informations sur le type de l'image pour déterminer les actions à suivre.
                    $typeImage = $em->getRepository('IngetisImagesBundle:TypeImage')->find($image->getIdTypeImage());
                    $crop = $typeImage->getCrop();
                    $resize = $typeImage->getResize();
                    $path = $typeImage->getPath();

                    // On test voir si l'image doit être redimensionné
                    if($resize == 1){
                        $ih = $this->container->get('ingetis_images.ImagesHandler');
                        if($ih->createScaledImage($path,basename($image->getPath()))){
                            return $this->redirect($this->generateUrl('ingetis_admin_images'));
                        }
                    }
                    if($crop == 1){
                        return  $this->redirect($this->generateUrl('ingetis_crop_images',
                            array('id' => $image->getId(), 'filename' => basename($image->getPath())))
                        );
                    }
                }
                return $this->redirect($this->generateUrl('ingetis_admin_images'));
            }
        }
        if($iframe == NULL){
            return $this->render('IngetisImagesBundle:Default:add_edit_image.html.twig',
                array(
                    'form'  =>  $form->createView(),
                    'id'    =>  $image->getId(),
                    'action'=>  "Edit"
                ));
        }else{
            return $this->render('IngetisImagesBundle:Default:iframe_add_edit_image.html.twig',
                array(
                    'form'  =>  $form->createView(),
                    'id'    =>  $image->getId(),
                    'action'=>  "Edit"
                ));
        }
    }

    public function removeAction(Image $Image, $type, $iframe = 0)
    {
        $em = $this->getDoctrine()->getManager();
        $typeImage = $Image->getTypeImage();
        $path = $typeImage->getPath();
        $thumb = $typeImage->getThumb();
        $em->remove($Image);
        $em->flush();

        $imageToRemove = $Image->getRootDir().$path.$Image->getImage();
        $imageThumbToRemove = $Image->getRootDir().$path.'thumbs/'.$Image->getImage();

        if ($imageToRemove && file_exists ($imageToRemove) ) {
            unlink($imageToRemove);
            if ($thumb == 1) {
                unlink($imageThumbToRemove);
            }
        }
        return $this->redirect($this->generateUrl('muzikspirit_back_image_list', array('iframe' => $iframe , 'type' => $type ))); // Redirection vers une nouvelle page
    }
}



