<?php
$path   = '../imagecache/';
$expire = 24*3600*14;

if(is_dir($path)) {

	if ( $handle = opendir( $path ) ) {
		while (false !== ($file = readdir($handle))) {
			$filelastmodified = filemtime($path.$file);
			if((time()-$filelastmodified) > $expire && is_file($path.$file))
			{
				unlink($path.$file);
			}
		}
		closedir($handle);
	}

}

?>