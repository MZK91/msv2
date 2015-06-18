<?php

namespace MuzikSpirit\BackBundle\Controller;

use MuzikSpirit\BackBundle\Entity\News;
use MuzikSpirit\BackBundle\Utilities\Crawler;
use MuzikSpirit\BackBundle\Utilities\Youtube;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

class AdminController extends Controller
{
    public function YoutubeAction($id){
        // set video data feed URL

        "https://www.googleapis.com/youtube/v3/videos?part=snippet&id=ew2Xh4gPots&fields=items/snippet/title,items/snippet/description&key=AIzaSyCdILi8yhSniTdGSyzHRHXdZjm6BKhb47w";

        $content = file_get_contents("http://www.youtube.com/oembed?url=http://www.youtube.com/watch?v=".$id."&format=json");
        $json_output = json_decode($content, true);

        /*
         $xml = file_get_contents("http://www.youtube.com/oembed?format=xml&url=http%3A%2F%2Fwww.youtube.com%2Fwatch%3Fv%3D".$id);

        //$video = new \SimpleXMLElement($xml);
        //exit(dump($video));
        /*$crawler = new Crawler($link);
        $crawler->get_page();
        $h1 = $crawler->get_h1();
        */
        // parse video entry

        $image = 'http://i3.ytimg.com/vi/'.$id.'/default.jpg';
        $title = htmlentities($json_output['title']);

        $data = <<<EOF
<videos>
    <video>
        <Title>$title</Title>
        <Image>$image</Image>
    </video>
</videos>
EOF;
        $response = new Response();
        $response->setContent($data);
        $response->headers->set('Content-Type', 'application/xml');

        return $response;
    }
    public function DailymotionAction($id){
        $feedURL = 'http://www.dailymotion.com/atom/video/'.$id;
        $xml = simplexml_load_file($feedURL);

        $title = htmlentities (preg_replace('/Dailymotion - /','',$xml->title));

        $image = "http://www.dailymotion.com/thumbnail/video/".$id;

        $data = <<<EOF
<videos>
    <video>
        <Title>$title</Title>
        <Image>$image</Image>
    </video>
</videos>
EOF;
        $response = new Response();
        $response->setContent($data);
        $response->headers->set('Content-Type', 'application/xml');

        return $response;
    }

    public function VimeoAction($id){
        $feedURL = 'http://vimeo.com/api/v2/video/'.$id.'.xml';
        $xml = simplexml_load_file($feedURL);
        $title =  $xml->video->title;
        $image =  $xml->video->thumbnail_medium;

        $data = <<<EOF
<videos>
    <video>
        <Title>$title</Title>
        <Image>$image</Image>
    </video>
</videos>
EOF;
        $response = new Response();
        $response->setContent($data);
        $response->headers->set('Content-Type', 'application/xml');

        return $response;
    }

    public function PreviewAction(Request $request){
        if ($request->getMethod() == 'POST') {
            $media = $request->request->get('media');
        }

        return $this->render('MuzikSpiritBackBundle:Admin:preview.html.twig',
            array(
                'media' => $media,
            )
        );
    }

    public function SameArtisteAction(Request $request, $type){
        $em = $this->getDoctrine()->getManager();
        // 1 news 2 video 3 clip 4 son 5 album 6 artiste 7 lyrics 8 lifestyle
        if ($request->getMethod() == 'POST') {
            $artiste = $request->request->get('find');

            if ($type == 'news') {
                $query = $em->getRepository('MuzikSpiritBackBundle:News')->searchNewsLinkQuery($artiste);
            }elseif($type == 'video'){
                $query = $em->getRepository('MuzikSpiritBackBundle:Video')->searchVideoLinkQuery($artiste);
            }elseif($type == 'clip'){
                $query = $em->getRepository('MuzikSpiritBackBundle:Clip')->searchClipLinkQuery($artiste);
            }elseif($type == 'son'){
                $query = $em->getRepository('MuzikSpiritBackBundle:Son')->searchSonLinkQuery($artiste);
            }elseif($type == 'album'){
                $query = $em->getRepository('MuzikSpiritBackBundle:Album')->searchAlbumLinkQuery($artiste);
            }elseif($type == 'artiste'){
                $query = $em->getRepository('MuzikSpiritBackBundle:Artiste')->searchArtisteLinkQuery($artiste);
            }elseif($type == 'lyrics'){
                $query = $em->getRepository('MuzikSpiritBackBundle:Lyrics')->searchLyricsLinkQuery($artiste);
            }elseif($type == 'lifestyle'){
                $query = $em->getRepository('MuzikSpiritBackBundle:Lifestyle')->searchLifestyleLinkQuery($artiste);
            }

            $data = $query->setMaxResults(10)->getQuery()->getResult();

            $encoders = array(new XmlEncoder(), new JsonEncoder());
            $normalizers = array(new GetSetMethodNormalizer());

            $serializer = new Serializer($normalizers, $encoders);

            $data = $serializer->serialize($data, 'xml');

            $response = new Response();
            $response->setContent($data);
            $response->headers->set('Content-Type', 'application/xml');

            return $response;
        }

    }

    public function GetImageAction(Request $request,$type){
        $em = $this->getDoctrine()->getManager();

        if ($request->getMethod() == 'POST') {
            $find = $request->request->get('find');
            $query = $em->getRepository('MuzikSpiritBackBundle:Image')->searchImageByTypeQuery($find,$type);
            $data = $query->setMaxResults(1)->getQuery()->getResult();

            $encoders = array(new XmlEncoder(), new JsonEncoder());
            $normalizers = array(new GetSetMethodNormalizer());

            $serializer = new Serializer($normalizers, $encoders);

            $data = $serializer->serialize($data, 'xml');

            $response = new Response();
            $response->setContent($data);
            $response->headers->set('Content-Type', 'application/xml');

            return $response;
        }

    }

    public function CrawlAction(Request $request){
        if ($request->getMethod() == 'POST') {
            $link = $request->request->get('link');

            $crawler = new Crawler($link);
            $crawler->get_page();
            $h1 = $crawler->get_h1();

            if ($h1 == '' || preg_match('/13or-du-hiphop/', $link)) {
                $title = $crawler->get_title();
            } else {
                $title = $h1;
            }

            $embed = $crawler->get_embed();

            $data = <<<EOF
<crawl>
    <item>
        <Title>$title</Title>
        <Embed><![CDATA[$embed]]></Embed>
    </item>
</crawl>
EOF;
            $response = new Response();
            $response->setContent($data);
            $response->headers->set('Content-Type', 'application/xml');

            return $response;
        }
    }
}