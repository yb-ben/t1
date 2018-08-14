<?php
/**
 * Created by PhpStorm.
 * User: sicmouse
 * Date: 2018/8/13
 * Time: 下午4:38
 */

class Request
{

    public $method;

    public $url ;

    public $queryString;

    public $input = [];

    public $params = [];

    public $path ;

    public $file = [];

    public $ip ;

    public $headers = [];

    public $cookies ;

    public $session ;


    public function getHeader(){}

    public function getMethod(){}

    public function getParams(){}

    public function getQueryString(){}

    public function getUrl(){}

    public function getIp(){}

    public function getPath(){}

    public function getCookie(){}

    public function getSession(){}


}