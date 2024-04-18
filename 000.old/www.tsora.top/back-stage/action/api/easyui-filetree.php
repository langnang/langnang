<?php


/*
 * @name 基于jquery-easyui的树
 *
 * @param string url
 * @param int id
 *
 * @return 
*/



$url=isset($_POST["url"])?$_POST["url"]:"/";
// echo $url;
$id=isset($_POST["id"])?intval($_POST["id"]):1;
// echo $id;
include_once("../file/open.php");
$files=array();
// $id=1;

foreach (json_decode(openFolder($_SERVER['DOCUMENT_ROOT'].$url),true) as $key => $value) {
	$file;
	if($value['filetype']=='dir'){
		$file['text']=$value['filename'];
		$file['id']=$id;
		$file['type']=$value['filetype'];
		$file['state']='closed';
		$file['url']=$url.$value['filename'].'/';
		$id++;
		array_push($files, $file);
	}
	unset($file);
}

foreach (json_decode(openFolder($_SERVER['DOCUMENT_ROOT'].$url),true) as $key => $value) {
	$file;
	if($value['filetype']=='file'){
		$file['text']=$value['filename'];
		$file['id']=$id;
		$file['type']=$value['filetype'];
		$file['url']=$url.$value['filename'];
		$id++;
		array_push($files, $file);
	}
	unset($file);
}


echo json_encode($files);
