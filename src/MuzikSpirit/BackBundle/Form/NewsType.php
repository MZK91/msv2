<?php

namespace MuzikSpirit\BackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NewsType extends AbstractType
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
                )
            ))
            ->add('artiste', null, array(
                'label' => 'Artiste',
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => "Artiste",
                )
            ))
            ->add('thumbNews', null, array(
                'label' => "Thumb News",
                'required'  => true,
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'Thumb News',
                )
            ))
            ->add('texte', 'textarea' , array(
                'label' => 'Texte',
                'required'  => true,
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
            ->add('adult', null, array(
                'required'  => false,
                'label' => 'Contenu réservé aux plus de 18 ans',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))

            ->add('section', null, array(
                'label' => 'Section',
                'required'  => true,
                'expanded'  => true,
                'attr' => array(
                    'placeholder' => 'Affecter la news à une section',
                ),


            ))
            ->add('envoyer', 'submit', array(
                'attr' => array(
                    'class' => 'btn btn-primary btn-sm'
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
            'data_class' => 'MuzikSpirit\BackBundle\Entity\News'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'muzikspirit_backbundle_news';
    }
}
