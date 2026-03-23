<?php
class Enemy {
    private $name;
    private $health;
    private $maxHealth;
    private $damage;
    
    public function __construct($name, $health, $damage) {
        $this->name = $name;
        $this->health = $health;
        $this->maxHealth = $health;
        $this->damage = $damage;
    }
    
    public function getName() { return $this->name; }
    public function isAlive() { return $this->health > 0; }
    
    public function takeDamage($amount) {
        $this->health = max(0, $this->health - $amount);
    }
    
    public function getDamage() { return $this->damage; }
}