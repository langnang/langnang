<?php

namespace Langnang\Typecho;

use Langnang\Typecho\TypechoInterface;
use Langnang\Typecho\TypechoModel;

class TypechoOptionModel extends TypechoModel
{
  public $name;
  public $user = 0;
  public $value;
  protected $suffix_tbname = "options";

  function setUser($user)
  {
    if (!is_null($user)) {
      $this->user = (int)$user;
    }
  }
}
