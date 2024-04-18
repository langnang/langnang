<?

namespace Langnang;

class lnArray
{
  static function to_array()
  {
  }

  /**
   * 一维数组转为树状数组
   */
  static function to_tree($array, $children_key)
  {
    $tree = [];
  }
  static function to_ini($array, $to_string = false)
  {
    $result = "";
    $delay = [];
    foreach ($array as $key => $value) {
      if (is_array($value)) {
        $delay[$key] = $value;
      } else {
        $result .= "$key = " . $value . "\n";
      }
    }
    foreach ($delay as $key => $value) {
      if (!$to_string) {
        $result .= "[$key]\n";
        $result .= self::to_ini($value, true);
      } else {
        $result .= "$key = " . implode(',', $value) . "\n";
      }
    }
    return $result;
  }
}
