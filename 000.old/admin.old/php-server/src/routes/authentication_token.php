<?php

use Langnang\Typecho\TypechoController;
use Langnang\Typecho\TypechoUserController;

function authentication_token($data, $db = array())
{
  $token = $data["token"];

  $_db = TypechoController::getDevConfig(null, $db);
  $_conn = Doctrine\DBAL\DriverManager::getConnection($_db);

  $user = new TypechoUserController(array(), $_conn, $_db);
  if ($user->select(array(
    "authCode" => $token,
  )) === FALSE) {
    return FALSE;
  } else {
    return $user;
  }
}
