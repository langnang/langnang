<?php

namespace Core;

class Illuminate
{
  public $name;
  public $alias;

  function __set($name, $value = null)
  {
    $this->{$name} = $value;
  }

  function __get($name)
  {
    return $this->{$name};
  }
  // private $aliases;

  // private function setName() {}
  // private function getName() {}
  // private function setAlias() {}
  // private function getAlias() {}

  // protected function _autoload() {}
  // protected function _run() {}
  // protected function _log() {}
  protected function _print(...$arguments)
  {
    echo "<a href='#Illuminate.$this->name'><h2 id='Illuminate.$this->name'>" . $this->name . "</h2></a>";
    // vars
    echo "<table><tbody>";
    echo '<tr class="h"><th colspan=2> Var </th><th> Local Value </th><th> Annotation </th></tr>';
    $vars = array_filter(array_keys(get_class_vars(get_class($this))), function ($var) {
      return !preg_match("/^_/", $var);
    });
    foreach ($vars as $var) {
      echo "<tr><td class=\"e\">$var</td><td class=\"v\">" . gettype($this->{$var}) . "</td><td class=\"v\">" . json_encode($this->{$var}) . "</td><td class=\"v\"></td></tr>";
    }
    unset($vars, $var);
    echo "</tbody></table>";

    // methods
    echo "<table><tbody>";
    echo '<tr class="h"><th colspan="2"> Methods </th><th> Annotation </th></tr>';
    $methods = array_filter(get_class_methods($this), function ($method) {
      // var_dump($method);
      return !preg_match("/^_/", $method);
    });
    foreach ($methods as $alias => $method) {
      echo "<tr><td class=\"e\">$method</td><td class=\"v\"></td><td class=\"v\"></td></tr>";
    }
    // if (count($methods) > 0) {

    // echo '<td class="e">' . implode(", ", $methods) . '</td>';
    // foreach (array_values($methods) as $alias => $method) {
    //   if (preg_match("/^_/", $method)) continue;
    //   echo "<tr><td class=\"e\">$alias</td><td class=\"v\">$method</td></tr>";
    // }
    // }
    unset($methods, $alias, $method);
    echo "</tbody></table>";
  }
}
