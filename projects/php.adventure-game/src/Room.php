<?php
class Room
{
  private $id;
  private $name;
  private $description;
  private $exits = [];
  private $items = [];
  private $enemy;

  public function __construct($id, $name, $description, $entities = [])
  {
    $this->id = $id;
    $this->name = $name;
    $this->description = $description;

    if (isset($entities['item'])) {
      $this->items[] = $entities['item'];
    }
    if (isset($entities['enemy'])) {
      $this->enemy = $entities['enemy'];
    }
  }

  public function getId()
  {
    return $this->id;
  }
  public function getName()
  {
    return $this->name;
  }
  public function getDescription()
  {
    return $this->description;
  }

  public function addExit($direction, $roomId)
  {
    $this->exits[$direction] = $roomId;
  }

  public function getExit($direction)
  {
    return $this->exits[$direction] ?? null;
  }

  public function getItem($name)
  {
    foreach ($this->items as $item) {
      if ($item->getName() === $name) {
        return $item;
      }
    }
    return null;
  }

  public function removeItem($name)
  {
    $this->items = array_filter($this->items, function ($i) use ($name) {
      return $i->getName() !== $name;
    });
  }

  public function getEnemy()
  {
    return $this->enemy;
  }
}
