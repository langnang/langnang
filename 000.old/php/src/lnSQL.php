<?

namespace Langnang;

class LnSQL
{
  /**
   * 生成SQL查询条件语句
   */
  static function sql_condition($conditions)
  {
    $sql = '';
    if (sizeof($conditions) == 0) {
      return $sql;
    }
    // $sql += 'WHERE ';
    foreach ($conditions as $_item) {
      $sql .= "AND `" . $_item["name"] . "` " . $_item["condition"] . " '" . $_item["value"] . "' ";
    }
    return "WHERE " . substr($sql, 4);
  }
}
