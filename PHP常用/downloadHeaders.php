<?php

function download($mimeType,$expire,$openinBrower,$name,$lastModified){

	$mimeType = $mimeType?:'application/octet-stream';
	$openinBrower ? 'inline' : 'attachment; filename="' . $name . '"';
	$gmdate = gmdate("D, d M Y H:i:s", time() + $this->expire) . ' GMT';
	header('Prama: public');
	header("Content-Type: $mimeType");
	header("Cache-control: max-age=$expire");
	header("Content-Disposition: $openinBrower");
	header("Content-Transfer-Encoding: binary");
	header("Expires: $gmdate");
	$lastModified && header("Last-Modified: $lastModified");
}