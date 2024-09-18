<?php

namespace Core;

class Illuminate
{
  public $name;

  public $alias;

  private $aliases;

  private function setName() {}
  private function getName() {}
  private function setAlias() {}
  private function getAlias() {}

  protected function _autoload() {}
  protected function _run() {}
  // protected function _log() {}
  protected function _print()
  {
    echo "<h2>" . $this->name . "</h2>";
    // vars
    echo "<table><tbody>";
    echo '<tr class="h"><th colspan="2">Vars</th></tr>';
    $vars = array_filter(array_keys(get_class_vars(get_class($this))), function ($var) {
      return !preg_match("/^_/", $var);
    });
    foreach ($vars as $var) {
      echo "<tr><td class=\"e\">$var</td><td class=\"v\">" . json_encode($this->{$var}) . "</td></tr>";
    }
    unset($vars, $var);
    echo "</tbody></table>";

    // methods
    echo "<table><tbody>";
    echo '<tr class="h"><th>Methods</th></tr>';
    $methods = array_filter(get_class_methods($this), function ($method) {
      // var_dump($method);
      return !preg_match("/^_/", $method);
    });
    if (count($methods) > 0) {

      echo '<td class="e">' . implode(", ", $methods) . '</td>';
      // foreach (array_values($methods) as $alias => $method) {
      //   if (preg_match("/^_/", $method)) continue;
      //   echo "<tr><td class=\"e\">$alias</td><td class=\"v\">$method</td></tr>";
      // }
    }
    unset($methods, $alias, $method);
    echo "</tbody></table>";
  }
}
