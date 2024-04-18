<?php

require_once __DIR__ . '/../../vendor/autoload.php';

require_once __DIR__ . "/../../../modules/typecho/Typecho.php";

use Langnang\Typecho\TypechoController;

$env_config = parse_ini_file(__DIR__ . "/../../../env.develop", true);
$env_config["__cloud__"] = array_merge($env_config["__cloud__"], isset($env_config["__local__"]) ? $env_config["__local__"] : array());
$_db = TypechoController::getDevConfig("");
$_conn = Doctrine\DBAL\DriverManager::getConnection($_db);
$faker = Faker\Factory::create();
$sql = "SELECT `authCode` FROM `" . $_db["dbname"] . "`.`typecho__users` WHERE `uid` = '1' ;";
$authCode = $_conn->fetchAssociative($sql)["authCode"];

define("API_PATH", "http://127.0.0.1:9090");
