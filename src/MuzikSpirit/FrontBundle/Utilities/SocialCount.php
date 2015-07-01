<?php

namespace MuzikSpirit\FrontBundle\Utilities;

Class SocialCount{

    private $url;

    private $googlePlusShares;

    private $facebookShares;

    private $twitterShares;

    private $pinterestShares;

    public function __construct($url){
        $this->url = $url;
    }


    public function getGooglePlusShareCount()
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://clients6.google.com/rpc");
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POSTFIELDS, '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"' . rawurldecode($this->url) . '","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        $curl_results = curl_exec($curl);
        curl_close($curl);
        $json = json_decode($curl_results, true);
        $result = isset($json[0]['result']['metadata']['globalCounts']['count']) ? intval($json[0]['result']['metadata']['globalCounts']['count']) : 0;
        $this->googlePlusShares = $result;

        return $result;
    }

    public function getFacebookShareCount()
    {
        $api = file_get_contents('http://graph.facebook.com/?id=' . $this->url);
        $obj = json_decode($api);
        $result = $obj->{'shares'};
        $this->facebookShares = $result;

        return $result;
    }

    public function getTwitterShareCount()
    {
        $api = file_get_contents( 'http://urls.api.twitter.com/1/urls/count.json?url=' . $this->url );
        $obj = json_decode( $api );
        $result = $obj->{'count'};
        $this->twitterPlusShares = $result;

        return $result;
    }

    public function getPinterestShareCount()
    {
        $json = file_get_contents( 'http://api.pinterest.com/v1/urls/count.json?url=' . $this->url );
        $result = preg_replace('/^.+"count":([0-9]+)\}.+/', "$1", $json);
        $this->pinterestShares = $result;

        return $result;
    }

    public function getTotalShares(){
        $result = $this->facebookShares + $this->googlePlusShares + $this->twitterShares + $this->pinterestShares;

        return $result;
    }


}