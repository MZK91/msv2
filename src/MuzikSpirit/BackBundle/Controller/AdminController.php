<?php

namespace MuzikSpirit\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MuzikSpirit\BackBundle\Utilities\Youtube;

class AdminController extends Controller
{
    public function YoutubeAction($id){
        // set video data feed URL
        $feedURL = 'http://gdata.youtube.com/feeds/api/videos/' . $id;

        // read feed into SimpleXML object
        $entry = simplexml_load_file($feedURL);

        // parse video entry
        $video = Youtube::parseVideoEntry($entry);
        $image = 'http://i3.ytimg.com/vi/'.$id.'/default.jpg';
        $title = $video->title;

        return $this->render('MuzikSpiritBackBundle:Admin:youtube.xml.twig',
            array(
                'title' => $title,
                'image' => $image,
            )
        );
    }
    public function DailymotionAction($id){
        $feedURL = 'http://www.dailymotion.com/atom/video/'.$id;
        $xml = simplexml_load_file($feedURL);

        $title = preg_replace('/Dailymotion - /','',$xml->title);

        $image = "http://www.dailymotion.com/thumbnail/video/".$id;

        return $this->render('MuzikSpiritBackBundle:Admin:youtube.xml.twig',
            array(
                'title' => $title,
                'image' => $image,
            )
        );
    }

    public function VimeoAction($id){
        $feedURL = 'http://vimeo.com/api/v2/video/'.$id.'.xml';
        $xml = simplexml_load_file($feedURL);
        $title =  $xml->video->title;
        $image =  $xml->video->thumbnail_medium;

        return $this->render('MuzikSpiritBackBundle:Admin:youtube.xml.twig',
            array(
                'title' => $title,
                'image' => $image,
            )
        );
    }
}