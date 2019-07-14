<?php

class Facade{
	
	protected static $bind = [];//类绑定

    protected static function createFacade(){

    }

    public static function bind($facade,$class = null){
        if (__CLASS__ != static::class) {
            return self::__callStatic('bind', func_get_args());
        }
        if(is_array($facade)){
            self::$bind = array_merge(self::$bind,$facade);
        }else{
            self::$bind[$facade] = $class;
        }
    }

    protected static function getFacadeClass(){}

	public static function __callStatic($name, $arguments)
    {
        return call_user_func_array([static::createFacade(),$name ],$arguments);
    }

}

class Test{}

class TestFacade extends Facade{

}

TestFacade::bind('TestFacade','Test');