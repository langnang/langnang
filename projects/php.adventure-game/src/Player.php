<?php
class Player
{
  private $name;
  private $health;
  private $maxHealth;
  private $gold;
  private $items = [];

  public function __construct($name, $health, $gold)
  {
    $this->name = $name;
    $this->health = $health;
    $this->maxHealth = $health;
    $this->gold = $gold;
  }

  public function getName()
  {
    return $this->name;
  }
  public function getHealth()
  {
    return $this->health;
  }
  public function getGold()
  {
    return $this->gold;
  }
  public function getItems()
  {
    return $this->items;
  }
  public function isAlive()
  {
    return $this->health > 0;
  }

  public function takeDamage($amount)
  {
    $this->health = max(0, $this->health - $amount);
  }

  public function addGold($amount)
  {
    $this->gold += $amount;
  }

  public function addItem($item)
  {
    $this->items[] = $item;
  }

  public function toArray()
  {
    return [
      'name' => $this->name,
      'health' => $this->health,
      'maxHealth' => $this->maxHealth,
      'gold' => $this->gold,
      'items' => array_map(function ($i) {
        return  $i->toArray();
      }, $this->items)
    ];
  }

  public function fromArray($data)
  {
    $this->name = $data['name'];
    $this->health = $data['health'];
    $this->maxHealth = $data['maxHealth'];
    $this->gold = $data['gold'];
    $this->items = array_map(function ($i) {
      return  new Item($i['name'], $i['type'], $i['value']);
    }, $data['items']);
  }
}
