<?php
	
	$data	= file_get_contents('imagecache/'.$_GET['image']);
	
	header("Content-type: $mime");
	header('Content-Length: ' . strlen($data));
	echo $data;
	exit();
	
?>