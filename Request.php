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

    public $url = '';

    public $input = [];

    public $params = [];

    public $path = '' ;

    public $file = [];

    public $ip ;

    public $headers = [];

    public $cookies ;

    public function __construct($get = [],$post =[],$request = [],$cookie = [],$session =[],$server = [],$env = [])
    {

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


    public function getUrl(){
        return $this->url;
    }

    public function getIp(){
        return $this->ip;
    }

    public function getPath(){
        return $this->path;
    }

    public function getCookie(){

    }




}