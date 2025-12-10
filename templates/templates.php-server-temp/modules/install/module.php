<?php

class InstallModule
{
  public static function render($data)
  {
    var_dump($data);
  }

  public static function render_view_declaration()
  {
    require_once __DIR__ . "/views/declaration.php";
    exit();
  }
}
