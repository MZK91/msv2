<?php

namespace MuzikSpirit\BackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LifestyleType extends AbstractType
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
            ->add('categoryLifestyle', null, array(
                'label' => 'Categorie',
                'required'  => true,
                'expanded'  => false,
                'multiple'  => false,
                'attr' => array(
                    'placeholder' => 'Type Article',
                ),
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
            'data_class' => 'MuzikSpirit\BackBundle\Entity\Lifestyle'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'muzikspirit_backbundle_lifestyle';
    }
}
