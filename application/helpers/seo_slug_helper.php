<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function seo_slug($string)
{
    $c = array (' ');
    $d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+');
    $string = str_replace($d, '', $string);
    $string = strtolower(str_replace($c, '-', $string));
    return $string;
}