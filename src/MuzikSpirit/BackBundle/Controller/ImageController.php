<?php

namespace MuzikSpirit\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MuzikSpirit\BackBundle\Form\ImagesType;
use MuzikSpirit\BackBundle\Entity\Images;

class ImageController extends Controller
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

    public function listAction($page, $type = 0, $iframe = 0)
    {
        $limit = $this->container->getParameter('max_articles');

        $em = $this->getDoctrine()->getManager();

        if($type == 0) {
            $dql = "SELECT img FROM MuzikSpiritBackBundle:Image img ORDER BY img.id DESC";
            $query = $em->createQuery($dql);
        }else{
            $dql = "SELECT img FROM MuzikSpiritBackBundle:Image img WHERE img.type = :type ORDER BY img.id DESC";
            $em->setParameter('type', $type);
            $query = $em->createQuery($dql);
        }
        $paginator  = $this->get('knp_paginator');
        $paginator = $paginator->paginate(
            $query,
            $page,
            $limit
        );

        if($iframe === 0) {
            return $this->render('MuzikSpiritBackBundle:Image:list.html.twig',
                array(
                    'pagination' => $paginator,
                    'page' => $page,
                    'type' => $type,
                    'titre' => 'Images',
                )
            );
        }else{
            return $this->render('MuzikSpiritBackBundle:Image:iframe_list.html.twig',
                array(
                    'pagination' => $paginator,
                    'page' => $page,
                    'type' => $type,
                    'titre' => 'Images',
                )
            );
        }
    }
    public function addImageAction( $iframe = NULL )
    {
        $Image = new Images();
        $form   = $this->createForm(new ImagesType(),$Image);
        $request = $this->getRequest(); // On récupére les donn type de methode POST ou GET
        if($request->isMethod('POST')){
            $em = $this->getDoctrine()->getManager(); // On récupère l'entity manager
            $form->bind($request); // On attribut toutes les données à l'objet form

            if($form->isValid()){

                $titre = $form->get('titre')->getData(); // On récupère le titre envoyer par le formulaire
                $slug = $this->container->get('slugify'); // Récupération du service Slugify


                $Image->fileSlug = $slug->slugify($titre); // On génére un nom de fichier propre en fonction du titre
                $em->persist($Image);
                $em->flush();
                // On récupére les informations sur le type de l'image pour déterminer les actions à suivre.
                $TypeImage = $em->getRepository('IngetisImagesBundle:TypeImage')->find($form->get('idTypeImage')->getData());
                $crop = $TypeImage->getCrop();
                $resize = $TypeImage->getResize();
                $path = $TypeImage->getPath();

                // On test voir si l'image doit être redimensionné
                if($resize == 1){
                    $ih = $this->container->get('ingetis_images.ImagesHandler');
                    if($ih->create_scaled_image($path,$Image->fileName)){
                        $Image->setPath($path.$Image->fileName);
                        $em->persist($Image);
                        $em->flush();
                        if($iframe == NULL){
                            return $this->redirect($this->generateUrl('ingetis_admin_images'));
                        }else{
                            return $this->redirect($this->generateUrl('ingetis_iframe_admin_images'));
                        }
                    }
                }
                if($crop == 1){
                    return  $this->redirect($this->generateUrl('ingetis_crop_images',
                        array('id' => $Image->getId(), 'filename' => $Image->fileName))
                    );
                }
                // DEFAULT ---->
            }
        }


        if($iframe == NULL){
            return $this->render('IngetisImagesBundle:Default:add_edit_image.html.twig', array(
                'form'  => $form->createView(),
                'id'    => 0
            ));
        }else{
            return $this->render('IngetisImagesBundle:Default:iframe_add_edit_image.html.twig', array(
                'form'  => $form->createView(),
                'id'    => 0
            ));
        }
    }

    public function multiAddImageAction( $iframe = NULL )
    {
        $Image = new Images();
        $form   = $this->createForm(new ImagesType(),$Image);
        $request = $this->getRequest(); // On récupére les donn type de methode POST ou GET
        if($request->isMethod('POST')){
            $em = $this->getDoctrine()->getManager(); // On récupère l'entity manager
            $form->bind($request); // On attribut toutes les données à l'objet form

            if($form->isValid()){


            }
        }


        if($iframe == NULL){
            return $this->render('IngetisImagesBundle:Default:add_edit_image.html.twig', array(
                'form'  => $form->createView(),
                'id'    => 0
            ));
        }else{
            return $this->render('IngetisImagesBundle:Default:iframe_add_edit_image.html.twig', array(
                'form'  => $form->createView(),
                'id'    => 0
            ));
        }
    }

    public function cropImageAction($id,$filename){
        $em             =   $this->getDoctrine()->getManager();
        $image          =   $em->getRepository('IngetisImagesBundle:Images')->find($id);
        $idTypeImage    =   $image->getIdTypeImage();
        $TypeImage    =   $em->getRepository('IngetisImagesBundle:TypeImage')->find($idTypeImage);

        $imagePath = __DIR__.'/../../../../web/images/tmp/'.$filename;

        list($width, $height) = getimagesize($imagePath);
        $orig_w = $width;
        $orig_h = $height;

        $form = $this->createFormBuilder()
            ->add('x',          'hidden')
            ->add('y',          'hidden')
            ->add('w',          'hidden')
            ->add('h',          'hidden')
            ->add('width',      'hidden', array( 'data' => $TypeImage->getWidth()    ) )
            ->add('height',     'hidden', array( 'data' => $TypeImage->getHeight()   ) )
            ->add('id',         'hidden', array( 'data' => $id                       ) )
            ->add('path',       'hidden', array( 'data' => $TypeImage->getPath()     ) )
            ->add('filename',   'hidden', array( 'data' => $filename                 ) )
            ->add('envoyer',    'submit')
            ->getForm();
        $request = $this->getRequest(); // On récupére les donn type de methode POST ou GET
        if($request->isMethod('POST')){

            $form->bind($request);
            if($form->isValid()){
                $data = $form->getData();
                $fileName = $data['filename'];

                $ih = $this->container->get('ingetis_images.ImagesHandler');
                $ih->imageCrop($data['filename'],$data['x'],$data['y'],$data['w'],$data['h'],$data['width'],$data['height']);
                //$fileName = $ih->imageConverter($data['path'],$data['filename'],'jpeg');
                $ih->moveToDir('images/tmp/'.$fileName,$data['path'].$fileName);
                if($image->getPath() == NULL){
                    $image->setPath($data['path'].$fileName);
                    $em->persist($image);
                    $em->flush();
                }
                return $this->redirect($this->generateUrl('ingetis_admin_images'));

            }
        }
        return $this->render('IngetisImagesBundle:Default:crop_image.html.twig', array(
            'form'      =>  $form->createView(),
            'image'     =>  $filename,
            'width'     =>  $TypeImage->getWidth(),
            'height'    =>  $TypeImage->getHeight(),
            'orig_w'    =>  $orig_w,
            'orig_h'    =>  $orig_h,
        ));
    }
    public function editAction(Images $image, $iframe = NULL )
    {
        $em = $this->getDoctrine()->getManager();
        /*
        $idTypeImage = $em->getRepository('IngetisImagesBundle:TypeImage')->find($image->getIdTypeImage());
        $image->setIdTypeImage($idTypeImage);
        */
        $form = $this->createForm(new ImagesType(), $image);

        $form->remove('idTypeImage');
        $request = $this->getRequest();
        if($request->isMethod('POST')){

            $form->bind($request);
            if($form->isValid()){
                $data = $form->getData();
                $em->persist($data);
                $em->flush();
                if($image->file != NULL){

                    $ih = $this->container->get('ingetis_images.ImagesHandler');

                    $imageInfo = $ih->imageInfo($image->getPath());

                    $extension = $image->file->guessExtension();

                    $FileName = $imageInfo['fileName'].'.'.$image->file->guessExtension();

                    $ih->moveToTmp($image->file,$FileName);

                    if($imageInfo['extension'] != $extension){
                        $ih->imageConverter('images/tmp/',$FileName,$imageInfo['extension']);
                    }
                    // On récupére les informations sur le type de l'image pour déterminer les actions à suivre.
                    $TypeImage = $em->getRepository('IngetisImagesBundle:TypeImage')->find($image->getIdTypeImage());
                    $crop = $TypeImage->getCrop();
                    $resize = $TypeImage->getResize();
                    $path = $TypeImage->getPath();

                    // On test voir si l'image doit être redimensionné
                    if($resize == 1){
                        $ih = $this->container->get('ingetis_images.ImagesHandler');
                        if($ih->create_scaled_image($path,basename($image->getPath()))){
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
    public function removeAction(Images $image)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($image);
        $em->flush();
        return $this->redirect($this->generateUrl('ingetis_admin_images')); // Redirection vers une nouvelle page
    }
}
