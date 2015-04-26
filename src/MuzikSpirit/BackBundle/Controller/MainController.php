<?php

namespace MuzikSpirit\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        $this->get('muzikspirit_back.notification')->notify('test');

        return $this->render('MuzikSpiritBackBundle:Default:index.html.twig');
    }
}
