<?php
/**
 * Created by PhpStorm.
 * User: sicmouse
 * Date: 2018/8/13
 * Time: 下午4:38
 */

class Request
{

    public $method = '';

    public $uri = '';

    public $input = [];

    public $params = [];

    public $path = '' ;

    public $file = [];

    public $ip ;

    public $domain;

    public $headers = [];

    public $cookies ;

    public $rawData = '';

    public $queryString = '';

    public function __construct($get = [],$post =[],$request = [],$cookies = [],$session =[],$server = [],$env = [])
    {

        $this->parseHeader($server);
        $this->parseInput();
        $this->parseParams();
        $this->parseCookies($cookies);

    }


    protected function parseHeader($header){

        if(function_exists('apache_request_headers')){
           $header =  apache_request_headers();
           $keys = array_keys($header);
           array_walk($keys,'strtolower');
            $this->headers = array_combine($keys,array_values($header));
        }
        foreach ($header as $k => $v){
            if(($pos = strpos('HTTP_',$k)) === false){
               $this->headers[ strtolower(str_replace('HTTP_','',$k)) ] = $v;
            }
        }
        if(isset($_SERVER['PHP_AUTH_DIGEST'])){
            $this->headers['authorization'] = $_SERVER['PHP_AUTH_DIGEST'];
        }
        if(isset($_SERVER['CONTENT_LENGTH'])){
            $this->headers['content-length'] = $_SERVER['CONTENT_LENGTH'];
        }
        if(isset($_SERVER['CONTENT_TYPE'])){
            $this->headers['content-type'] = $_SERVER['CONTENT_TYPE'];
        }
        if(isset($_SERVER['REQUEST_METHOD'])){
            $this->method = $_SERVER['REQUEST_METHOD'];
        }
        if(isset($_SERVER['REQUEST_URI'])){
            $this->uri = $_SERVER['REQUEST_URI'];
        }
        if(isset($_SERVER['REMOTE_ADDR'])){
            $this->ip = $_SERVER['REMOTE_ADDR'];
        }
        if(isset($_SERVER['QUERY_STRING'])){
            $this->queryString = $_SERVER['QUERY_STRING'];
        }
        if(isset($_SERVER['PATH_INFO'])){
            $this->path = $_SERVER['PATH_INFO'];
        }
    }


    protected function parseInput(){
        $this->rawData = file_get_contents('php://iuput');
        $this->input = explode('&', filter_input(INPUT_POST,FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    }

    protected function parseParams(){
        $this->params = explode('&',filter_input(INPUT_GET,FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    }

    protected function parseCookies($cookies){
        $this->cookies = $cookies;
    }




    public function getHeader($name = null){
        if(!$name)
            return $this->headers;
        elseif(is_string($name)){
            if(isset($this->headers[$name]))
                return $this->headers[$name];
        }
        elseif(is_array($name)){
            return array_intersect_key($this->headers,array_values($name));
        }

        throw new \Exception;
    }

    public function getMethod(){
        return $this->method;
    }

    public function getParams($name = null){
        if(!$name){
            return $this->params;
        }
        elseif(is_string($name) ){
            if(isset($this->params[$name])){
                return $this->params[$name];
            }
        }
        elseif (is_array($name)){
            return array_intersect_key($this->params,array_values($name));
        }
        throw new \Exception;
    }

    public function getInput($name = null){
        if(!$name){
            return $this->input;
        }
        elseif(is_string($name) ){
            if(isset($this->input[$name])){
                return $this->input[$name];
            }
        }
        elseif (is_array($name)){
            return array_intersect_key($this->input,array_values($name));
        }
        throw new \Exception;
    }



}

