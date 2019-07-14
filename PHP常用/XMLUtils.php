<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/20
 * Time: 21:16
 */

class XMLUtils
{

    public static function traver(SimpleXMLIterator $iterator){
        $return = [];
        for ($iterator->rewind();$iterator->valid();$iterator->next()){
            if(!isset($return[$iterator->key()])){
                $return[$iterator->key()] = [];
            }
            if ($iterator->hasChildren()) {
                $return[$iterator->key()][] = self::traver($iterator->current());
            }else{
                $return[$iterator->key()][] = strval($iterator->current());
            }
        }
        return $return;
    }

}