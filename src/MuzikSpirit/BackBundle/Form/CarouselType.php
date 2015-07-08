<?php

namespace MuzikSpirit\BackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CarouselType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('typeArticle', null, [
                'label' => 'Section',
                'required'  => true,
                'expanded'  => true,
                'attr' => [
                    'placeholder' => 'Affecter une section',
                ],
            ])
            ->add('titre')
            ->add('lien')
            ->add('description')
            ->add('section', null, [
                'label' => 'Section',
                'required'  => true,
                'expanded'  => true,
                'attr' => [
                    'placeholder' => 'Affecter une section',
                ],
            ])
            ->add('id_image', 'text', [
                "mapped" => false,
            ])
            ->add(
                'envoyer',
                'submit',
                [
                    'attr' => [
                        'class' => 'btn btn-lg btn btn-danger',
                    ],
                ]
            )
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MuzikSpirit\BackBundle\Entity\Carousel'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'muzikspirit_backbundle_carousel';
    }
}
