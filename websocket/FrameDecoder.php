<?php
/**
 * Created by PhpStorm.
 * User: sicmouse
 * Date: 2018/8/10
 * Time: 下午4:30
 */
class FrameDecoder
{

    private $fin = 0 ;

    private $rsv = 0x0 ;

    private $opcode = 0;

    private $mask = 1;

    private $sevenBit = 0;

    private  $payloadLen = 0;

    private $maskingKey = null ;// if MASK set to 1;

    private $payloadData = '' ;

    private $length = 0 ;



    public function parsePacket($packet){
        $this->parseLength($packet);
        $this->parseFirstByte($packet{0});
        $this->parseMaskBit();
        $leftPacket = $this->parsePayloadLen($packet);
        $this->mask && $this->parseMaskingKey(substr($leftPacket,0,4));
        $this->parsePayloadData(substr($leftPacket,4));
        unset($packet,$leftPacket);
        return new Frame([
            'fin' => $this->fin ,
            'rsv' => $this->rsv ,
            'opcode' => $this->opcode,
            'mask' => $this->mask,
            'sevenBit' => $this->sevenBit,
            'payloadLen' => $this->payloadLen,
            'maskingKey' => $this->maskingKey,
            'payloadData' => $this->payloadData,
            'length' => $this->length
        ]);
    }



    private function parseLength($data){
        $this->length = strlen($data);
    }

    private function parseFirstByte($firstByte){

        $this->fin = $firstByte & 0x80;

        $this->rsv = $firstByte & 0x70;

        $this->opcode = $firstByte & 0x0f ;
    }


    private function parseMaskBit($secondByte = ''){

    }

    private function parsePayloadLen($packet){
        $this->sevenBit = $v = substr($packet,1,1) & 0x7f;
        if($v > -1 && $v < 126){
            $this->payloadLen= $v;
            $leftPacket = substr($packet , 2);
        }elseif($v == 126){
            $this->parseTwoBytePayloadLen(substr($packet,2,2));
            $leftPacket = substr($packet , 4);
        }elseif($v == 127){
            $this->parseFourBytePayloadLen(substr($packet,4,8));
            $leftPacket = substr($packet,10);
        }else{
            throw new Exception();
        }
        return $leftPacket;
    }

    private function parseTwoBytePayloadLen($twoBytes){
        $this->payloadLen = ord($twoBytes{0}) << 8 + ord($twoBytes{1}) ;
    }

    private function parseFourBytePayloadLen($fourBytes){
        $this->payloadLen = intval(unpack('H*',$fourBytes)[0],10);
    }

    private function parseMaskingKey($fourBytes){
        $this->maskingKey = $fourBytes;
    }

    private function parsePayloadData($payloadData){

        $this->payloadData = $payloadData;
    }

    public function decodePayloadData($data,$mask){
        foreach (str_split($data) as $i => $v){
            $data{$i} = chr(ord($v) ^ ord($mask[$i % 4]));
        }
        $this->payloadData = $data;
    }

}