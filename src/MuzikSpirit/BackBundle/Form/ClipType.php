<?php

namespace MuzikSpirit\BackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClipType extends AbstractType
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
            ->add('son', null, array(
                'label' => "Son",
                'required'  => true,
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'Son',
                )
            ))
            ->add('featuring', null, array(
                'label' => "Featuring",
                'required'  => false,
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'Featuring',
                )
            ))
            ->add('media', null, array(
                'label' => "Media",
                'required'  => true,
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'Media',
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
                    'placeholder' => 'Ajouter une miniature pour la news',
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
            ->add('duration','hidden')
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
            'data_class' => 'MuzikSpirit\BackBundle\Entity\Clip'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'muzikspirit_backbundle_clip';
    }
}
