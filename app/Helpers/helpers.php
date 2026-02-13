<?php

function prx($arr)
{
    echo "" ;
    print_r($arr) ;
    die() ;
}

if (!function_exists('replaceStr')) {
    function replaceStr($str)
    {
        
        return preg_replace('/\s+/', '_', $str);
     
        // return preg_replace('/[\s-]+/', '_', $str);
    }
}