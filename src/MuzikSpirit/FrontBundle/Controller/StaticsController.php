<?php

namespace MuzikSpirit\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StaticsController extends Controller
{
    public function mailmdpAction($username)
    {
        return $this->render('MuzikSpiritFrontBundle:Statics:mailmdp.html.twig', array('username' => $username));
    }
}
