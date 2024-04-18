<?php

namespace Langnang\Typecho;

class TypechoContentModel extends TypechoModel
{
  public $cid;
  public $title;
  public $slug;
  public $created;
  public $modified;
  public $text;
  // 摘要
  public $abstract;
  public $order = 0;
  public $authorId;
  public $template;
  public $type;
  public $status = 'publish';
  public $password;
  public $commentsNum = 0;
  public $allowComment = 1;
  public $allowPing = 1;
  public $allowFeed = 1;
  public $parent = 0;

  protected $suffix_tbname = "contents";

  function setCid($cid)
  {
    if (!is_null($cid)) {
      $this->cid = (int)$cid;
    }
  }
  function setCreated($created)
  {
    if (!is_null($created)) {
      $this->created = (int)$created;
    }
  }
  function setModified($modified)
  {
    if (!is_null($modified)) {
      $this->modified = (int)$modified;
    }
  }
  function setText($text)
  {
    if (!is_null($text)) {
      if (substr($text, 0, 15) == '<!--markdown-->') {
        $this->text = substr($text, 15);
      } else {
        $this->text = $text;
      }
    } else {
      $this->text = '';
    }
    $this->setAbstract();
  }
  function setAbstract()
  {
    if (strpos($this->text, '<!--more-->') !== false) {
      $this->abstract = mb_substr($this->text, 0, strpos($this->text, '<!--more-->'), 'utf-8');
    } else {
      $this->abstract = mb_substr($this->text, 0, 200, 'utf-8');
    }
  }
  function setParent($parent)
  {
    if (!is_null($parent)) {
      $this->parent = (int)$parent;
    }
  }
}
