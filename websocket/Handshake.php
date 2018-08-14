<?php
/**
 * Created by PhpStorm.
 * User: sicmouse
 * Date: 2018/8/10
 * Time: 下午5:05
 */

class Handshake
{

    private $request = null;

    private $allowOrigin = [];

    private $allowIP = [] ;


  /*  public function parseHeader($raw){
       $headers  = explode($raw,'\r\n');
       $keys = array_keys($headers);
        array_walk($keys,function (&$item){
            return strtolower($item);
        });
       $this->headers = array_combine($keys, array_values($headers));
       unset($headers);
    }*/

    public function __construct($request)
    {
        $this->request = $request;
    }


    public function response(){
        $response = 'HTTP/1.1 101 Switching Protocols'."\r\n".
            'Upgrade: websocket'."\r\n".
            'Sec-Websocket-Accept: '.$this->websocketAcceptKey($this->headers['sec-websocket-key'])."\r\n".
            'Connection: Upgrade'."\r\n".
            "Date: ".(new DateTime(time(),new DateTimeZone('Asia/Shanghai')))->format(DateTime::RFC822).''."\r\n"
        ;
        return $response;
    }


    public function setAllowOrigin($allowOrigin = []){
        array_merge($this->allowOrigin,$allowOrigin);
    }

    public function setAllowIP($allowIP = []){
        array_merge($this->allowIP,$allowIP);
    }

    public function allowOrigin($origin){
       return in_array($origin,$this->allowOrigin);
    }

    public function allowIP($ip){
        return in_array($ip,$this->allowIP);
    }


    private function websocketAcceptKey($seckey){
       return base64_encode(sha1($seckey . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11'));
    }
}