<?php
$fn = filter_input(INPUT_POST,'fn',FILTER_SANITIZE_STRING);
if(!$fn)
	die();
$regex = '/^[a-zA-Z0-9-_]{1,16}$/';
//白名单验证
$fn = filter_var($fn,FILTER_VALIDATE_REGEXP,['options' =>['regexp' => $regex]]);


if ($_FILES['f1']['error'] !== UPLOAD_ERR_OK) {
    throw new \Exception('upload error');
}
if($_FILES['f1']['size'] > 1024*1024*10){
    throw new \Exception('over size limit');
}
if (!is_uploaded_file($_FILES['f1']['tmp_name'])) {
   throw new \Exception( 'is not an uploaded file');
};
$target = $fn;
if (!move_uploaded_file($_FILES['f1']['tmp_name'], $target)) {
    throw new \Exception( 'false to move the uploaded file');
}
chmod($target, 0444);
