<?php

use Langnang\Typecho\TypechoController;
use Langnang\Typecho\TypechoUserController;

$GLOBALS["ROUTER_PARAMS"]["select_typecho_user"] = array(
  "post" => array(
    "uids" => array(
      "desc" => "用户编号",
      "type" => "array",
      "default" => [],
    ),
  ),
  "token" => array(
    "desc" => "用户令牌",
    "type" => "string",
    "required" => true
  ),
);
function select_typecho_user($data, $db = array())
{
  $_data = $data["post"];
  $token = $data["token"];
  $_db = TypechoController::getDevConfig(null, $db);
  $_conn = Doctrine\DBAL\DriverManager::getConnection($_db);

  if (sizeof($_data["uids"]) === 0) {
    return $data["user"];
  }

  // $user = new TypechoUserController($_data, $_conn, $_db);
  // if ($user->login() === FALSE) return "登录失败，用户名或密码错误";
}
