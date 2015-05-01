<?php


namespace MuzikSpirit\BackBundle\Twig\Extension;

class BbcodeExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('BBCode', array($this, 'BBCodeMediaFilter')),
        );
    }

    public function BBCodeMediaFilter($media)
    {
        $media = preg_replace("/\[youtube\](.*)\[\/youtube\]/Usi", '<iframe width="640" height="360" src="https://www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>', $media);
        $media = preg_replace("/\[dailymotion\](.*)\[\/dailymotion\]/Usi", '<object width="640" height="420"><param name="movie" value="http://www.dailymotion.com/swf/video/$1"></param><param name="allowFullScreen" value="true"></param><param name="allowScriptAccess" value="always"></param><embed type="application/x-shockwave-flash" src="http://www.dailymotion.com/swf/video/$1" width="640" height="420" allowfullscreen="true" allowscriptaccess="always"></embed></object>', $media);
        $media = preg_replace("/\[vimeo\](.*)\[\/vimeo\]/Usi", '<iframe src="http://player.vimeo.com/video/$1?title=0&amp;byline=0&amp;portrait=0&amp;color=2FA694" width="640" height="420" frameborder="0"></iframe>', $media);
        return $media;
    }

    public function getName()
    {
        return 'myfilter_extension';
    }
}