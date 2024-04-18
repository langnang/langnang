<?

namespace Langnang;

class lnFunction
{
  static function get_var_type($var)
  {
    foreach (['array', 'bool', 'float', 'int',  'null', 'object', 'string', 'nan',] as $name) {
      if (call_user_func("is_" . $name, $var)) {
        return $name;
      }
    }
    return false;
  }
}
