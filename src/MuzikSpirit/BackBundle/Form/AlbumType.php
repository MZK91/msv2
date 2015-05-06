<?php

namespace MuzikSpirit\BackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AlbumType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', null, array(
                'label' => 'Titre',
                'required'  => true,
                'trim'=> true,
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'Titre',
                    'name' => 'titre_article',
                    'id' => 'titre_article'
                )
            ))
            ->add('artiste', null, array(
                'label' => 'Artiste',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => "Artiste",
                    'name' => 'titre_article',
                    'id' => 'titre_article'
                )
            ))
            ->add('album', null, array(
                'label' => "Titre de l'album",
                'required'  => true,
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'Titre album',
                )
            ))
            ->add('tracklist', 'textarea' , array(
                'label' => 'Tracklist',
                'required'  => false,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('texte', 'textarea' , array(
                'label' => 'Texte',
                'required'  => false,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('image', null, array(
                'label' => 'Miniature',
                'required'  => true,
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'Miniature',
                )
            ))

            ->add('section', null, array(
                'label' => 'Section',
                'required'  => true,
                'expanded'  => true,
                'attr' => array(
                    'placeholder' => 'Affecter une section',
                ),
            ))
            ->add('envoyer', 'submit', array(
                'attr' => array(
                    'class' => 'btn btn-lg btn btn-danger'
                )
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MuzikSpirit\BackBundle\Entity\Album'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'muzikspirit_backbundle_album';
    }
}
