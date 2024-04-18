<?php

use Langnang\Typecho\TypechoController;
use Langnang\Typecho\TypechoUserController;

$GLOBALS["ROUTER_PARAMS"]["select_typecho_user_login"] = array(
  "post" => array(
    "name" => array(
      "desc" => "用户账号",
      "type" => "string",
      "required" => true
    ),
    "password" => array(
      "desc" => "用户密码",
      "type" => "string",
      "required" => true
    ),
  )
);
/**
 * 用户登录
 */
function select_typecho_user_login($data, $db = array())
{
  $_data = $data["post"];
  $_db = TypechoController::getDevConfig(null, $db);
  $_conn = Doctrine\DBAL\DriverManager::getConnection($_db);

  $user = new TypechoUserController($_data, $_conn, $_db);
  $token = $user->login(array("password" => $_data["password"]));
  if ($token === FALSE) return "登录失败，用户名或密码错误";

  return [
    "token" => $token
  ];
}
