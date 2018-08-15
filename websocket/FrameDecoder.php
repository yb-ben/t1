<?php
/**
 * Created by PhpStorm.
 * User: sicmouse
 * Date: 2018/8/10
 * Time: 下午4:30
 */
class FrameDecoder
{

    const WS_OP_AGAIN = 0X0;//还有后续分片
    const WS_OP_TEXT = 0X1;//文本
    const WS_OP_BINARY = 0X2;//二进制
    const WS_OP_CLOSE = 0X8;//关闭
    const WS_OP_PING = 0X9;
    const WS_OP_PONG = 0XA;

    private $opcodes = [
      self::WS_OP_AGAIN,self::WS_OP_TEXT,self::WS_OP_BINARY,self::WS_OP_PING,self::WS_OP_PONG,self::WS_OP_CLOSE
    ];

    private $fin = 0 ;

    private $rsv = 0;

    private $opcode ;

    private $mask = 1;

    private $sevenBit = 0;

    private  $payloadLen = 0;

    private $maskingKey = null ;// if MASK set to 1;

    private $payloadData = '' ;

    private $length = 0 ;

    private $data = [];



    public function parseFrame($packet, $skip = 0){
        $packet = substr($packet,$skip);
        $this->parseLength($packet);
        $this->parseFirstByte($packet{0});
        $this->parseMaskBit();
        $skip += $this->parsePayloadLen($packet);
        $this->mask && $this->parseMaskingKey(substr($packet,$skip,4));
        $skip += 4;
        $this->parsePayloadData(substr($packet,$skip ,$this->payloadLen));
        $skip += $this->payloadLen;
        ($this->opcode === self::WS_OP_TEXT || $this->opcode === self::WS_OP_BINARY )
            && $this->data[] = new WebSocketFrame($this->fin,$this->rsv,$this->opcode,$this->mask,$this->sevenBit,$this->payloadLen,$this->maskingKey,$this->payloadData,$this->length);


        if($this->fin === 1 && $this->opcode === self::WS_OP_AGAIN){
            return $this->data;
        }
        return $this->parseFrame($packet,$skip);
    }



    private function parseLength($data){
        $this->length = strlen($data);
    }

    private function parseFirstByte($firstByte){

        $this->fin = $firstByte & 0x80;

        $this->rsv = $firstByte & 0x70;

        $this->opcode = $firstByte & 0x0f ;

        if(!in_array($this->opcode,$this->opcodes))
            throw new \Exception;
    }


    private function parseMaskBit($secondByte = ''){

    }

    private function parsePayloadLen($packet){
        $this->sevenBit = $v = substr($packet,1,1) & 0x7f;
        if($v > -1 && $v < 126){
            $this->payloadLen= $v;
            $skip = 1;
        }elseif($v == 126){
            $this->parseTwoBytePayloadLen(substr($packet,2,2));
            $skip = 2 ;
        }elseif($v == 127){
            $this->parseFourBytePayloadLen(substr($packet,4,8));
            $skip = 8;
        }else{
            throw new \Exception;
        }
        return $skip;
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