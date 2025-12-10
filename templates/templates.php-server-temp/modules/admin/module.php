<?php

require_once "models/AdminModel.php";
require_once "interfaces/AdminInterfaces.php";
require_once "controllers/AdminController.php";

class AdminModule
{
  public static function render()
  {
  }
  public static function render_view($data)
  {
    echo "Admin View";
  }
}
