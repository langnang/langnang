<?php
class Item
{
  private $name;
  private $type;
  private $value;

  public function __construct($name, $type, $value)
  {
    $this->name = $name;
    $this->type = $type;
    $this->value = $value;
  }

  public function getName()
  {
    return $this->name;
  }
  public function getType()
  {
    return $this->type;
  }
  public function getValue()
  {
    return $this->value;
  }

  public function getDescription()
  {
    $types = [
      'weapon' => '武器',
      'armor' => '防具',
      'potion' => '药水',
      'treasure' => '宝物'
    ];
    return ($types[$this->type] ?? '物品') . " (价值: {$this->value})";
  }

  public function toArray()
  {
    return [
      'name' => $this->name,
      'type' => $this->type,
      'value' => $this->value
    ];
  }
}
