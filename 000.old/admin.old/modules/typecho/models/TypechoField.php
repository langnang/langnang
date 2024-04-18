<?php

namespace Langnang\Typecho;

class TypechoFieldModel extends TypechoModel
{
  public $cid;
  public $name;
  public $type;
  public $str_value;
  public $int_value;
  public $float_value;
  protected $suffix_tbname = "fields";

  function setValue($value)
  {
    if (is_null($this->type)) {
      if (is_string($value)) {
        $this->type = "str";
        $this->str_value = $value;
      } else if (is_integer($value)) {
        $this->type = "int";
        $this->int_value = (int)$value;
      } else if (is_float($value)) {
        $this->type = "float";
        $this->float_value = $value;
      }
    } else {
      switch ($this->type) {
        case "str":
          $this->str_value = $value;
          break;
        case "int":
          $this->int_value = (int)$value;
          break;
        case "float":
          $this->float_value = $value;
          break;
      }
    }
  }
  function setInt_Value($int_value)
  {
    if (!is_null($int_value)) {
      $this->int_value = (int)$int_value;
    }
  }
}
