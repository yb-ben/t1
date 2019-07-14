<?php
function resizeImage($uploadfile,$name,$newwidth,$newheight)
{
    $uploadfile = imagecreatefrompng($uploadfile);
    //取得当前图片大小
    $width = imagesx($uploadfile);
    $height = imagesy($uploadfile);
    //生成缩略图的大小
    if(($width > $newwidth) || ($height > $newheight)) {
        $uploaddir_resize = imagecreate($newwidth, $newheight);
        imagecopyresized($uploaddir_resize, $uploadfile, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        imagejpeg($uploaddir_resize,$name);
        imagedestroy($uploaddir_resize);
    } else{
        imagejpeg($uploadfile,$name);
    }
}
