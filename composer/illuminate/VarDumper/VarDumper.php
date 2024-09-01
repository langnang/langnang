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
    $return = "<pre style='" . $this->getElementStyles('container') . "'>";
    foreach ($args as $arg) {
      // var_dump($arg);
      switch (gettype($arg)) {
        case "array":
        case "object":
          $return .= "<details open>"
            . "<summary>"
            . "<font style='" . $this->getElementStyles('summary') . "'> $file:$line:</font>"
            . "</summary>";
          break;
        default:
          $return .= "<font style='" . $this->getElementStyles('summary') . "'> $file:$line:</font>";
          break;
      }
      $return .= $this->print_type($arg) . "</details></pre>";
    }
    echo $return;
  }
  function print_type($value, $depth = 0)
  {
    $max_depth = config('this.max_depth');
    $return = '';
    // var_dump(gettype($value));
    switch (gettype($value)) {
      case 'object':
        if ($depth > $max_depth) return;
        $class = get_class($value);
        $reflection = new \ReflectionClass($class);
        // $reflection = $reflection->newInstance((array)$value);
        $properties = $reflection->getProperties();
        $size = count($properties);
        // var_dump($class, $reflection, $properties, $size);
        $return = ($depth == 0 ? "" : "\n") .
          "<details" . ($this->theme('details.open') === true || $depth === 0 ? ' open' : '') . ">" . "<summary>" . "<font style='" . $this->getElementStyles('summary') . "'>" . str_repeat("   ", $depth)
          . "  <font style='" . $this->getElementStyles('object_type') . "'><b>object</b>($class)[" . $size . "]</font>"
          . "</font>"
          . "</summary>";
        foreach ($properties as $property) {
          // var_dump($property->getValue($value));
          // $return .= "\n";
          if ($property->isPublic()) {
            $return .= str_repeat("   ", $depth + 1) . "<i>public</i> '<font style='" . $this->getElementStyles('object_key') . "'>" . $property->getName() . "</font>' => " . $this->print_type($property->getValue($value), $depth + 1);
          } elseif ($property->isProtected()) {
            $return .= str_repeat("   ", $depth + 1) . "<i>protected</i>" . $property->getName() . "' => "  . $this->print_type($property->getValue($value), $depth + 1);
          } elseif ($property->isPrivate()) {
            $return .= str_repeat("   ", $depth + 1) . "<i>private</i>" . $property->getName() . "' => "  . $this->print_type($property->getValue($value), $depth + 1);
          }
          $return .= "\n";
        }
        $return .= "</details>";
        break;

      case 'array':
        if ($depth > $max_depth) return;
        $return .= ($depth == 0 ? "" : "\n") . "<details" . ($this->theme('details.open') === true || $depth === 0 ? ' open' : '') . "><summary><font style='" . $this->getElementStyles('summary') . "'>" .  str_repeat("   ", $depth) . "  <font style='" . $this->getElementStyles('array_type') . "'><b>array</b> <i>(size=" . count($value) . ")</i> </font></font></summary>";
        if (count($value) == 0) {
          $return .=  str_repeat("   ", $depth + 1) . "<i><font style='" . $this->getElementStyles('empty') . "'>empty</font></i>";
        } else if ($depth == $max_depth) {
          $return .= str_repeat("   ", $depth + 1) . " ...";
        } else {
          foreach ($value as $k => $v) {
            $return .= str_repeat("   ", $depth + 1) . (is_int($k) ? ("<font style='" . $this->getElementStyles('array_key') . "'>$k</font>") : ("'<font style='" . $this->getElementStyles('array_key') . "'>$k</font>'")) . " => " . $this->print_type($v, $depth + 1);
            $return .= "\n";
          }
        }
        $return .= "</details>";
        break;
      case 'string':
        $return .= "<small>string</small> <font style='" . $this->getElementStyles('string') . "'>'$value'</font> <i>(length=" . strlen($value) . ")</i>";
        break;
      case 'integer':
        $return .= "<small>int</small> <font style='" . $this->getElementStyles('integer') . "'>$value</font>";
        break;
      case 'NULL':
        $return .= "<font style='" . $this->getElementStyles('null') . "'>null</font>";
        break;
      default:
        break;
    }
    // var_dump(gettype($value));
    // if(is_object($value))
    return preg_replace(['/\n\n/', '/\n<\/details>/', '/<summary>\n/'], ["\n", "</details>", "<summary>"], $return);
  }

  function getElementStyles($ele)
  {
    $theme = $this->theme('styles');
    $styles = $theme[$ele] ?? [];
    $return = '';
    foreach ($styles as $name => $value) {
      $return .= "$name: $value; ";
    }
    return $return;
  }

  function theme($key)
  {
    return config($this->alias . '.themes.options.' . config($this->alias . '.themes.default') . '.' . $key);
  }
}
