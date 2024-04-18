<?php
/**
@name 返回directory实例

*/


function return_dir($directory){
	// echo $directory;
	$d = scandir($_SERVER['DOCUMENT_ROOT'].$directory);

	array_shift($d);
	array_shift($d);
	echo json_encode($d);
}