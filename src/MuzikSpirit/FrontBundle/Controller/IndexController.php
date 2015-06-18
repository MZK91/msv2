<?php

namespace MuzikSpirit\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller
{
    public function viewAction($section = 'all')
    {

        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('MuzikSpiritBackBundle:Article')->getArticleLimit(30);
        $news = $em->getRepository('MuzikSpiritBackBundle:News')->getNewsLimit(5);
        $clip = $em->getRepository('MuzikSpiritBackBundle:Clip')->getClipLimit(5);
        $video = $em->getRepository('MuzikSpiritBackBundle:Video')->getVideoLimit(5);
        $son = $em->getRepository('MuzikSpiritBackBundle:Son')->getSonLimit(5);
        $lyrics = $em->getRepository('MuzikSpiritBackBundle:Lyrics')->getLyricsLimit(5);
        $album = $em->getRepository('MuzikSpiritBackBundle:Album')->getAlbumLimit(5);

        return $this->render('MuzikSpiritFrontBundle:Index:index.html.twig',
            array(
                'article' => $article,
                'news' => $news,
                'video' => $video,
                'son' => $son,
                'clip' => $clip,
                'lyrics' => $lyrics,
                'album' => $album,
            )
        );
    }
}
