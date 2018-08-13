<?php
/**
 * Created by PhpStorm.
 * User: sicmouse
 * Date: 2018/8/10
 * Time: 下午5:05
 */

class Handshake
{

    public $headers = [];



    public function parseHeader($raw){
       $headers  = explode($raw,'\r\n');
       $keys = array_keys($headers);
        array_walk($keys,function (&$item){
            return strtolower($item);
        });
       $this->headers = array_combine($keys, array_values($headers));
       unset($headers);
    }

    public function reply(){
        $response = 'HTTP/1.1 101 Switching Protocols'."\r\n".
            'Content-Length: 0'. "\r\n".
            'Upgrade: websocket'."\r\n".
            'Sec-Websocket-Accept: '.$this->websocketAcceptKey($this->headers['sec-websocket-key'])."\r\n".
            'Connection: Upgrade'."\r\n".
            "Date: ".(new DateTime(time(),new DateTimeZone('Asia/Shanghai')))->format(DateTime::RFC822).''."\r\n"
        ;
    }


    public function allowOrigin($origins){

    }



    private function websocketAcceptKey($seckey){
       return base64_encode(sha1($seckey . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11'));
    }
}