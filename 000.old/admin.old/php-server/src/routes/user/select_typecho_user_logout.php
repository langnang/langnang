<?php

use Langnang\Typecho\TypechoController;
use Langnang\Typecho\TypechoUserController;

$GLOBALS["ROUTER_PARAMS"]["select_typecho_user_logout"] = array(
  "token" => array(
    "desc" => "用户令牌",
    "type" => "string",
    "required" => true
  ),
);
/**
 * 用户登录
 */
function select_typecho_user_logout($data, $db = array())
{
  $_data = $data["post"];
  $_db = TypechoController::getDevConfig(null, $db);
  $_conn = Doctrine\DBAL\DriverManager::getConnection($_db);

  // $user = new TypechoUserController($_data, $_conn, $_db);
  // if ($user->login() === FALSE) return "登录失败，用户名或密码错误";

  // return [
  //   "token" => $user->authCode,
  // ];
}
