<?php

if(!function_exists('http_build_url')) {
    function http_build_url($url_arr)
    {
        $new_url = $url_arr['scheme'] . "://" . $url_arr['host'];
        if (!empty($url_arr['port']))
            $new_url = $new_url . ":" . $url_arr['port'];
        $new_url = $new_url . $url_arr['path'];
        if (!empty($url_arr['query']))
            $new_url = $new_url . "?" . $url_arr['query'];
        if (!empty($url_arr['fragment']))
            $new_url = $new_url . "#" . $url_arr['fragment'];
        return $new_url;
    }
}