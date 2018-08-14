<?php

class FrameEncoder{




    public function encode(Array $data){
      $raw = array_map([$this,'parse'],$data);
    }


    private function parse($data){

    }



}