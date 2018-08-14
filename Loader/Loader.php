<?php
/**
 * Created by PhpStorm.
 * User: sicmouse
 * Date: 2018/8/10
 * Time: 下午1:10
 */

class Loader
{

    /**
     * 路径映射
     * @var array
     */
    public  $namespaceMap = [];


    public $classMap = [];


    public $files = [];



    public function register($prepend = false){
       spl_autoload_register([$this,'loadClass'],true,$prepend);
   }


   public function unregister(){
       spl_autoload_unregister([$this,'loadClass']);
   }



    /**
     * 自动加载函数
     */
    public function loadClass($className){
          if($fileName = $this->findFile($className)) {
              include $fileName;
              return true;
          }
    }





    /**
     * 根据完全类名查找类文件
     * @param $className
     * @return bool|mixed
     */
    public function findFile($className){

        if(isset($this->classMap[$className])){
            return $this->classMap[$className];
        }

        return $this->parseNamespace($className);
    }


    public function addNamespaceMap(Array $map){
        foreach($map as $namespace => $path)
            $this->namespaceMap[$namespace] = $path;
    }



    public function addClassMap(Array $map){
        foreach ($map as $className => $path)
           $this->classMap[$className] = $path;
    }


    public function addFiles(Array $files){
        array_merge($this->files,$files);
    }

    private function parseNamespace($className){
        $key = strtoupper($className{0});
        if(isset($key)){
            foreach ($this->namespaceMap[$key] as $k => $v ){
                if(strpos($v,$className)){
                   return str_replace($k,$v,$className);
                }
            }
        }
    }

}