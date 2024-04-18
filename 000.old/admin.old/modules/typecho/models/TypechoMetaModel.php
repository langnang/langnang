<?php

namespace Langnang\Typecho;

class TypechoMetaModel extends TypechoModel
{
  /**
   * @var int $mid 标识ID
   */
  public $mid;
  /**
   * @var string $mid 标识名称
   */
  public $name;
  /**
   * @var string $mid 标识别名
   */
  public $slug;
  /**
   * @var string $mid 标识类型，branch||category||tag||...
   */
  public $type;
  /**
   * @var string $mid 标识描述
   */
  public $description;
  /**
   * @var int $mid 标识关联的内容数，默认为0
   */
  public $count = 0;
  /**
   * @var int $mid 标识排序，默认为0
   */
  public $order = 0;
  /**
   * @var int $mid 标识的上一级标识ID，默认为0（根）
   */
  public $parent = 0;

  protected $suffix_tbname = "metas";

  function setMid($mid)
  {
    if (!is_null($mid)) {
      $this->mid = (int)$mid;
    }
  }
  function setCount($count)
  {
    if (!is_null($count)) {
      $this->count = (int)$count;
    } else {
      $this->count = 0;
    }
  }
  function setOrder($order)
  {
    if (!is_null($order)) {
      $this->order = (int)$order;
    } else {
      $this->order = 0;
    }
  }
  function setParent($parent)
  {
    if (!is_null($parent)) {
      $this->parent = (int)$parent;
    } else {
      $this->parent = 0;
    }
  }
}
