<?php

namespace Langnang\Typecho;

use Langnang\Typecho\TypechoInterface;
use Langnang\Typecho\TypechoModel;

class TypechoRelationshipMotel extends TypechoModel
{
  public $cid;
  public $mid;
  protected $suffix_tbname = "relationships";

  function setCid($cid)
  {
    if (!is_null($cid)) {
      $this->cid = (int)$cid;
    }
  }
  function setMid($mid)
  {
    if (!is_null($mid)) {
      $this->mid = (int)$mid;
    }
  }
}
