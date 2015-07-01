<?php

namespace MuzikSpirit\FrontBundle\Controller;

use MuzikSpirit\FrontBundle\Utilities\SocialCount;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class AjaxController extends Controller
{
    /**
     * Return le fichier xml qui contient toutes les information sur les partages de la page fourni en URL
     *
     * @param String $url
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function ShareCountAction(Request $request)
    {
        $url = $request->query->get('url');
        $socialCount = new SocialCount($url);

        $facebook = $socialCount->getFacebookShareCount();
        $twitter = $socialCount->getTwitterShareCount();
        $google = $socialCount->getGooglePlusShareCount();
        $pinterest = $socialCount->getPinterestShareCount();
        $total = $socialCount->getTotalShares();

        $data = <<<EOF
<data>
    <url>$url</url>
    <shares>
        <facebook>$facebook</facebook>
        <twitter>$twitter</twitter>
        <google>$google</google>
        <pinterest>$pinterest</pinterest>
        <total>$total</total>
    </shares>
</data>
EOF;
        $response = new Response();
        $response->setContent($data);
        $response->headers->set('Content-Type', 'application/xml');

        return $response;
    }
}
