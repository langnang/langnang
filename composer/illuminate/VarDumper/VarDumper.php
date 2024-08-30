<?php

namespace Illuminate\VarDumper;

class VarDumper
{
  function print($trace)
  {
    // var_dump($trace);
    $file = $trace['file'];
    $line = $trace['line'];
    $args = $trace['args'];
    $return = "<pre style='font-size: 87.5%;'>";
    foreach ($args as $arg) {
      // var_dump($arg);
      switch (gettype($arg)) {
        case "array":
        case "object":
          $return .= "<details open><summary><small style='float: left;'> $file:$line:</small></summary>";
          break;
        default:
          $return .= "<small style='float: left;'> $file:$line:</small>";
          break;
      }
      $return .= $this->print_type($arg) . "</details></pre>";
    }
    echo $return;
  }
  function print_type($value, $depth = 0)
  {
    $max_times = 3;
    $return = '';
    // var_dump(gettype($value));
    switch (gettype($value)) {
      case 'object':
        if ($depth > $max_times) return;
        $class = get_class($value);
        $reflection = new \ReflectionClass($class);
        // $reflection = $reflection->newInstance((array)$value);
        $properties = $reflection->getProperties();
        $size = count($properties);
        // var_dump($class, $reflection, $properties, $size);
        $return = ($depth == 0 ? "" : "\n") . str_repeat("   ", $depth) . "  <b>object</b>($class)[" . $size . "]" . "\n";
        foreach ($properties as $property) {
          // var_dump($property->getValue($value));
          if ($property->isPublic()) {
            $return .= str_repeat("   ", $depth + 1) . "<i>public</i> '" . $property->getName() . "' => " . $this->print_type($property->getValue($value), $depth + 1) . "\n";
          } elseif ($property->isProtected()) {
            $return .= str_repeat("   ", $depth + 1) . "<i>protected</i>" . $property->getName() . "' => "  . $this->print_type($property->getValue($value), $depth + 1) . "\n";
          } elseif ($property->isPrivate()) {
            $return .= str_repeat("   ", $depth + 1) . "<i>private</i>" . $property->getName() . "' => "  . $this->print_type($property->getValue($value), $depth + 1) . "\n";
          }
        }
        break;

      case 'array':
        if ($depth > $max_times) return;
        $return .= ($depth == 0 ? "" : "\n") . str_repeat("   ", $depth) . "  <b>array</b> <i>(size=" . count($value) . ")</i>";
        if (count($value) == 0) {
          $return .= "\n" . str_repeat("   ", $depth + 1) . "<i><font color='#888a85'>empty</font></i>";
        } else if ($depth == $max_times) {
          $return .= "\n" . str_repeat("   ", $depth + 1) . " ...";
        } else {
          foreach ($value as $k => $v) {
            $return .=  "\n" . str_repeat("   ", $depth + 1) . (is_int($k) ? $k : "'$k'") . " => " . $this->print_type($v, $depth + 1);
          }
        }
        break;
      case 'string':
        $return .= "<small>string</small> <font color=\"#cc0000\">'$value'</font> <i>(length=" . strlen($value) . ")</i>";
        break;
      case 'integer':
        $return .= "<small>int</small> <font color=\"#4e9a06\">$value</font>";
        break;
      case 'NULL':
        $return .= "<font color=\"##3465a4\">null</font>";
        break;
      default:
        break;
    }
    // var_dump(gettype($value));
    // if(is_object($value))
    return preg_replace(['/\n\n/'], ["\n"], $return);
  }
}
