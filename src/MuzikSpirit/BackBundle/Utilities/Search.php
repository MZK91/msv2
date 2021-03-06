<?php

namespace MuzikSpirit\BackBundle\Utilities;

class Search
{
    public static function find_to_regexp($find, $strict = 0)
    {
        if (strict == 0) {
            $find = strip_tags($find);
            $find = trim($find);
            $find = strtolower($find);
            $find = preg_replace('/ /', 'B', $find);
            $find = preg_replace('/\$/', 'S', $find);
            $find = preg_replace('/\W/', 'W', $find);
            $find = preg_replace('/[^a-zA-Z0-9ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ&\$]/', '.', $find);
            $find = preg_replace('/\.\++|B/', '.+', $find);
            $find = preg_replace('/[àáâãäåa]/', '[àáâãäåa]', $find);
            $find = preg_replace('/[òóôõöøo]/', '[òóôõöo]', $find);
            $find = preg_replace('/[èéêëe&]/', '[èéêëe&]', $find);
            $find = preg_replace('/[cç]/', '[cç]', $find);
            $find = preg_replace('/[ìíîïi]/', '[ìíîïi]', $find);
            $find = preg_replace('/[ùúûüu]/', '[ùúûüu]', $find);
            $find = preg_replace('/[ñn]/', '[ñn]', $find);
            $find = preg_replace('/s/i', '[s[:punct:]]', $find);
            $find = preg_replace('/W/', '[[:punct:][:space:]]{0,1}', $find);
            $find = preg_replace('/\.+/', '.', $find);
            $find = '(^|[^[:alpha:]])' . $find . '($|[^[:alpha:]])';
        } else {
            $find = strip_tags($find);
            $find = trim($find);
            $find = strtolower($find);
            $find = preg_replace('/\$/', 'S', $find);
            $find = preg_replace('/[^a-zA-Z0-9ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ&\$<>%-]/', '.{1,2}', $find);
            $find = preg_replace('/[àáâãäåa]/', '[àáâãäåa]', $find);
            $find = preg_replace('/[òóôõöøo]/', '[òóôõöo]', $find);
            $find = preg_replace('/[èéêëe]/', '[èéêëe&]', $find);
            $find = preg_replace('/[cç]/', '[cç]', $find);
            $find = preg_replace('/[ìíîïi]/', '[ìíîïi]', $find);
            $find = preg_replace('/[ùúûüu]/', '[ùúûüu]', $find);
            $find = preg_replace('/[ñn]/', '[ñn]', $find);
            $find = preg_replace('/s/i', '[s[:punct:]]', $find);
            $find = preg_replace('/-/', '[[:punct:][:space:]]{0,2}', $find);
            $find = '(^|[^[:alpha:]])' . $find . '($|[^[:alpha:]])$';
        }
        return $find;
    }
}