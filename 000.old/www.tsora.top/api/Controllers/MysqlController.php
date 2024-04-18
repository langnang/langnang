<?php

/**
 * 
 */
class MysqlController
{
	
	function index()
	{
		$mysql=array(
			"host"=>"39.108.130.236",
			"username"=>"tsora",
			"password"=>"ezRvXnXIk0bmW8en",
			"dbname"=>"tsora",
			"tbname"=>""
		);
		return $mysql;
	}
	function connect()
	{
		$mysql=self::index();
		$link=mysqli_connect($mysql["host"],$mysql["username"],$mysql["password"],$mysql["dbname"]);
		return $link;
	}
	function select($tbname)
	{
		$link=self::connect();
		echo $tbname;

	}
	function insert()
	{

	}
	function delete()
	{

	}
	function update()
	{

	}
}