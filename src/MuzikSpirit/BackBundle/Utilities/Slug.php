<?php

namespace MuzikSpirit\BackBundle\Utilities;

/**
 * Class Slug
 * @package MuzikSpirit\BackBundle\Utilities
 */
class Slug
{
    /**
     * Convertion d'une chaine de caractère en URL propre
     * @param string $url
     * @return mixed|string
     */
    public static function slug($url)
    {
            $url = stripslashes(trim($url));
            $url = strtr(
                $url,
                "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ$",
                "AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNns"
            );
            $url = strtolower($url);
            $url = preg_replace('/[^a-z0-9-]/', '-', $url);
            $url = preg_replace('/[-]{2,}/', '-', $url); //On enlève les underscore si ils sont au moins répétés deux fois
            $url = preg_replace('/^[-]/', '', $url); //On enlève les underscore en début de chaine
            $url = preg_replace('/[-]$/', '', $url); //On enlève les underscore en fin de chaine

            return $url;
    }
}