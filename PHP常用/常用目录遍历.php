<?php
// glob遍历
function traverseDir_v1($dir)
{
    $dir = rtrim($dir,'\\/').DIRECTORY_SEPARATOR;
    foreach (glob($dir . '*') as $item) {
        echo $item,PHP_EOL;
        foo($item);
    }
}

// opendir readdir 遍历
function traverseDir_v2($dir)
{
    $dir = rtrim($dir, '\\/').DIRECTORY_SEPARATOR;
    if ($fp = opendir($dir)) {
        while (false !== ($file = readdir($fp))) {
            if($file === '.' || $file === '..' )
                continue;
            if(is_dir($dir.$file)) {
                echo $file , ' dir ',PHP_EOL;
                traverseDir_v2($dir . $file);
            }else{
                echo $file,PHP_EOL;
            }

        }
        closedir($fp);
    }
}