<?php
/** 
 * @name PHP路由功能简单实现
 * @desc PHP简单实现MVC路由功能
 * @Auth TSORA
 */ 


if($_SERVER["REQUEST_URI"]===$_SERVER["SCRIPT_NAME"]||strlen($_SERVER["REQUEST_URI"])<strlen($_SERVER["SCRIPT_NAME"])){
	include_once("Views/index.html");
	return;
}
$router=explode("/",substr($_SERVER["REQUEST_URI"],strlen($_SERVER["SCRIPT_NAME"])+1));

if(count($router)===1){
	$router["controller"]=ucfirst($router[0]);
	$router["function"]="index";
	$router["param"]="";
}else if(count($router)===2){
	$router["controller"]=ucfirst($router[0]);
	$router["function"]=$router[1];
	$router["param"]="";

}else{
	$router["controller"]=ucfirst($router[0]);
	$router["function"]=$router[1];
	$router["param"]=$router[2];
}


$data=$_POST["data"];
echo $data;
include_once("Controllers/".$router["controller"]."Controller.php");


call_user_func_array(array($router["controller"]."Controller",$router["function"]),array($router["param"],0));




?>
