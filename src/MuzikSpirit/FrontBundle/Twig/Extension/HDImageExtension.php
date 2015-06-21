<?php


namespace MuzikSpirit\FrontBundle\Twig\Extension;

class HDImageExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('HDImage', array($this, 'HDImageFilter')),
        );
    }

    public function HDImageFilter($image)
    {
        $image = preg_replace('/default.jpg/','mqdefault.jpg',$image);
        return $image;
    }

    public function getName()
    {
        return 'hd_image_extension';
    }
}