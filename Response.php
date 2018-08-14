<?php
/**
 * Created by PhpStorm.
 * User: sicmouse
 * Date: 2018/8/14
 * Time: 上午9:56
 */

class Response
{

    public $version = 'HTTP/1.1';

    public $code = 200 ;

    public $header = [] ;

    public $payload = '';

    private $length = 0;


    public static $mime = [
        'json' =>'application/json; charset=utf-8',
        'text'=> 'text/html; charset=utf-8',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'file' => 'application/octet-stream',
        'xml' => 'text/xml; charset=utf-8'
    ];



    public function statusCode($code = 200){
        $this->code = $code;
        return $this;
    }

    public function setHeader($key,$value = ''){
        if(empty($value)){
           if(isset($this->header[$key])) {
               unset($this->header[$key]);
           }
        }else{
            $this->header[$key] = $value;

        }
        return $this;
    }


    public function __call($name, $arguments)
    {
        if(isset(self::$mime[$name])){
            $this->header['content-type'] = self::$mime[$name];
            if($name === 'json')
               $arguments = json_encode($arguments,JSON_UNESCAPED_UNICODE);
            $this->length = strlen($arguments);
            $this->payload = $arguments;
        }
        return $this;
    }



    public function filter(){

    }



}