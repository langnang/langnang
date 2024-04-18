<?php

use Langnang\Typecho\TypechoContentController;
use Langnang\Typecho\TypechoController;

function select_typecho_post_random($data, $db = array())
{
  $_data = $data["post"];

  $_db = TypechoController::getDevConfig($_data["prefix"], $db);
  $_conn = Doctrine\DBAL\DriverManager::getConnection($_db);

  $contents = (new TypechoContentController(array(), $_conn, $_db))->random();
  $result =
    select_typecho_post_list(
      $data,
      $db,
      array(
        "contents" => $contents,
        "is_call_content_count" => false,
      )
    );
  return $result["rows"];
}
