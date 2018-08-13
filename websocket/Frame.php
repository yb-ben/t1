<?php
/**
 * Created by PhpStorm.
 * User: sicmouse
 * Date: 2018/8/10
 * Time: 下午4:34
 */

class Frame
{

    public $fin = 0 ;

    public $rsv = 0x0 ;

    public $opcode = 0;

    public $mask = 1;

    public $sevenBit = 0 ;

    public  $payloadLen = 0;

    public $maskingKey = null ;

    public $payloadData = '' ;

    public $length = 0 ;


    public function __construct($data)
    {
        foreach ($data as $k => $v){
            $this->$k = $v;
        }
    }


}