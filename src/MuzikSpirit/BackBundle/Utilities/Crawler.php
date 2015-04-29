<?php

namespace MuzikSpirit\BackBundle\Utilities;


class Crawler{
    private $url;
    private $html_code;
    private $title;

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getHtmlCode()
    {
        return $this->html_code;
    }

    /**
     * @param mixed $html_code
     */
    public function setHtmlCode($html_code)
    {
        $this->html_code = $html_code;
    }



    public function __construct($url){
        $this->url = $url;
    }
    function ascii_to_iso($text){

        $patterns = array();
        $patterns[0] = '/&#8211;/';
        $patterns[1] = '/&#8212;/';
        $patterns[2] = '/&#8216;/';
        $patterns[3] = '/&#8217;/';
        $patterns[4] = '/&#8218;/';
        $patterns[5] = '/&#8220;/';
        $patterns[6] = '/&#8221;/';
        $patterns[7] = '/&#8222;/';
        $patterns[8] = '/&#8230;/';

        $replacements = array();

        $replacements[0] = '-';
        $replacements[1] = '-';
        $replacements[2] = '\'';
        $replacements[3] = '\'';
        $replacements[4] = '\'';
        $replacements[5] = '"';
        $replacements[6] = '"';
        $replacements[7] = '"';
        $replacements[7] = '-';
        return preg_replace($patterns, $replacements, $text);
    }


    function get_page(){
        $this->curl = curl_init();
        // Set options
        curl_setopt ( $this->curl, CURLOPT_URL, $this->url);
        curl_setopt ( $this->curl, CURLOPT_POST, false );
        curl_setopt ( $this->curl, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $this->curl, CURLOPT_HEADER, false );
        /*curl_setopt ( $this->curl, CURLOPT_COOKIE, $this->cookie_name );
        curl_setopt ( $this->curl, CURLOPT_COOKIEJAR, $this->cookie_name );
        curl_setopt ( $this->curl, CURLOPT_COOKIEFILE, $this->cookie_name );*/
        curl_setopt($this->curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        // Execute request
        $result = curl_exec ( $this->curl );
        // Error handling
        if ( curl_errno ( $this->curl ) )
        {
            $this->error = array(
                curl_errno($this->curl),
                curl_error($this->curl),
            );
            curl_close ( $this->curl );
            return false;
        }
        curl_close ( $this->curl );
        $this->html_code = utf8_encode($result);
        return $result;
    }
    function get_title(){
        preg_match('/<title>([\s\S.]+)<\/title>/i',$this->html_code, $matches);
        //print_r($matches);
        $title = $matches[0];
        $title = preg_replace('/<br(\s*)?\/?>|[\r\n]+/i','',nl2br($title));
        //echo 'title :'.$title;
        $title = html_entity_decode(strip_tags($title));
        $title = $this->ascii_to_iso($title);
        return $title;
    }
    function get_h1(){
        $h1 = '';
        preg_match_all('/<h1.+?\/h1>/is',$this->html_code,$matches,PREG_PATTERN_ORDER);
        //print_r($matches);
        foreach($matches[0] as $match){
            if(preg_match('/2dopeboyz\.com/i',$this->url)){
                if(preg_match('/first/',$match)){
                    $h1 = $match;
                    $h1 = str_replace(" (Video)", "", $h1);
                    break;
                }
            }
            if(preg_match('/freeonsmash\.com|silklyrics/i',$this->url)){
                if(preg_match('/entry-title/',$match)){
                    $h1 = $match;
                    $h1 = str_replace("VIDEO:", "", $h1);
                    $h1 = str_replace(" | OnSMASH", "", $h1);
                    break;
                }
            }
            if(preg_match('/rapgenius\.com/i',$this->url)){
                if(preg_match('/song_title/',$match)){
                    $h1 = preg_replace('/ lyrics/i','',$match);
                    break;
                }
            }
            if(preg_match('/"title"/i',$match)){
                $h1 = $match;
                break;
            }
            $h1 = $match;
        }
        //echo $h1;
        $h1 = mb_convert_encoding($h1,'iso-8859-1', 'ASCII');
        $h1 = preg_replace('/\s+/',' ',$h1);
        $h1 = trim(preg_replace('/[\n\r\t]/','',strip_tags(html_entity_decode($h1))));
        $h1 = $this->ascii_to_iso($h1);
        return $h1;
    }

    function get_embed(){
        preg_match_all('/<iframe.+\/iframe>/i',$this->html_code,$matches);
        $ok = 0;
        foreach($matches[0] as $match){
            if(preg_match('/youtube/i',$match) && $ok == 0){
                $embed = $match;
                $ok = 1;
                break;
            }
            if(preg_match('/dailymotion/i',$match) && $ok == 0){
                $embed = $match;
                $ok = 1;
                break;
            }
            if(preg_match('/soundcloud/i',$match) && $ok == 0){
                $embed = $match;
                $ok = 1;
                break;
            }
            if(preg_match('/vimeo/i',$match) && $ok == 0){
                $embed = $match;
                $ok = 1;
                break;
            }
            if(!preg_match('/facebook|twitter/i',$match)){
                $embed = $match;
                $ok = 1;
                break;
            }
        }
        return $embed;
    }
    function get_lyrics(){
        if(preg_match('/rapgenius/',$this->url)){
            $text = preg_replace('/[\s\S].*?(<div.*?class="lyrics_container".*?>)(.*?)(<\/div>).*?[\s\S].+/is','$2',$this->html_code);

        }elseif(preg_match('/musicplayon/',$this->url)){
            $text = preg_replace('/[\s\S].*?(<div.*?id="theLyrics".*?>)(.*?)(<\/div>).*?[\s\S].+/is','$2',$this->html_code);

        }elseif(preg_match('/silklyrics/',$this->url)){
            preg_match('/<fb:like.+font="" \/><\/span><p>([\S\s.]+)<div id="fb-root"><\/div>/i',$this->html_code,$match);
            $text = preg_replace('/\<br(\s*)?\/?\>/i', "\n", $match[0]);

        }elseif(preg_match('/hotnewsonglyrics/',$this->url)){
            preg_match('/alt="ringtone" \/><\/span>([\s\S.]*)<small>.Link for Website/i',$this->html_code,$match);
            $text = preg_replace('/alt.+\/span>([\S\s.]+)/i','$1', $match[0]);
            $text = preg_replace('/\<br(\s*)?\/?\>/i', "\n", $text);
            $text = strip_tags(html_entity_decode($text));
            $text = preg_replace('/.+Ringtone to your Cell/i','',$text);
            $text = preg_replace('/.Link for Website/i','',$text);

        }elseif(preg_match('/urbanislandz/',$this->url)){
            preg_match('/<div class="single">([\s\S.]*?)<div class="cleaner">/i',$this->html_code,$match);
            $text = preg_replace('/\<br(\s*)?\/?\>/i', "\n", $match[0]);
            $text = strip_tags(html_entity_decode($text));


        }elseif(preg_match('/directlyrics/',$this->url)){

            preg_match('/<div class="lyrics lyricsselect">([\S\s.]+?)<\/div>/',$this->html_code,$match);
            $text = preg_replace('/\<br(\s*)?\/?\>/i', "\n", $match[0]);
            $text = preg_replace('/\n\n\n\n\n\n\n\n\(adsbygoogle.+window.adsbygoogle.+push.+\);\n\n/','',strip_tags($text));
        }

        $text = preg_replace('/[\n\r\t ]*$/is','',preg_replace('/^[\n\r\t ]*(.+)/is','$1',strip_tags(html_entity_decode($text))));
        $text = $this->ascii_to_iso($text);
        return $text;
    }
}
?>