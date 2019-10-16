<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/20
 * Time: 15:54
 */

class FileUtils
{

    /**
     * 遍历指定目录 递归
     * @param $dir
     * @return array|null
     */
    public static function traver($dir,$pattern = '*'){
        $dir = realpath($dir);
        $info = [];

            foreach (glob($dir . '/' . $pattern, GLOB_NOSORT) as $item) {
                if (is_dir($item)){
                    $info[basename($item)] = self::traver($item);
                }else
                    $info[] = basename($item);
            }
        return $info;
    }

    public static function listDir($dir){
        $dir = realpath($dir);
        $info = [];
        foreach (new DirectoryIterator($dir) as $item) {
            if ($item->isDot()) continue;
            if ($item->isDir()) {
                $r = self::listDir($item->getPathname());
                $info[$item->getFilename()] = $r;
            } else {
                $info[] = $item->getFilename();
            }
        }
        return $info;
    }

    public static function iterate($dir){
        $stack = new SplStack;
        $info = [];
        $fsi = new F(new DirectoryIterator(realpath($dir)),0);
        $stack->push($fsi);
        while(!$stack->isEmpty()) {
            $f = $stack->pop();
            $info[$f->getFilename()] = null;
            if ($f->iterator->isDir()) {
                foreach (new FilesystemIterator($f->iterator->getPathname()) as $item){
                    $stack->push(new F($item,$f->layer+1));
                }
            }
        }
    }
}



