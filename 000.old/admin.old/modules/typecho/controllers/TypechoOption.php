<?php

namespace Langnang\Typecho;

/**
 * @package TypechoOptionController
 * @method create 创建表
 * @method create_secondary 创建副表
 * @method create_summary 创建总表
 * @method drop 删除表
 * @method insert 新增列
 * @method delete 删除列
 * @method update 更新列
 * @method replace 替换列
 * @method count 统计列
 * @method is_exists 校验列存在
 * @method select 查询列
 * @method list 查询多列
 */
class  TypechoOptionController extends TypechoOptionModel implements TypechoInterface
{
  function create()
  {
    $sql = "CREATE TABLE `$this->dbname`.`$this->tbname`  (
      `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
      `user` int(10) UNSIGNED NOT NULL DEFAULT 0,
      `value` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
      PRIMARY KEY (`name`, `user`) USING BTREE
    ) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;";
    return $this->conn->executeStatement($sql);
  }
  function create_secondary()
  {
  }
  function create_summary()
  {
  }
  function drop()
  {
    $sql = "DROP TABLE IF EXISTS `$this->dbname`.`$this->tbname` ;";
    $this->conn->executeStatement($sql, (array)$this);
  }
  function insert()
  {
    $sql = "INSERT INTO `$this->dbname`.`$this->tbname` (`name`, `user`, `value`) VALUES (:name, :user, :value) ;";
    return  $this->conn->executeStatement($sql, (array)$this);
  }
  function delete()
  {
    $sql = "DELETE FROM `$this->dbname`.`$this->tbname` WHERE `name` = :mid AND `user` = :user;";
    return $this->conn->executeStatement($sql, (array)$this);
  }
  function update()
  {
    $sql = "UPDATE `$this->dbname`.`$this->tbname` SET `value` = :value WHERE `name` = :name AND `user` = :user ;";
    return $this->conn->executeStatement($sql, (array)$this);
  }
  function replace()
  {
    $sql = "REPLACE INTO `$this->dbname`.`$this->tbname` (`name`, `user`, `value`) VALUES (:name, :user, :value) ;";
    return $this->conn->executeStatement($sql, (array)$this);
  }
  function count()
  {
  }
  function is_exists()
  {
    $sql = "SELECT COUNT(*) FROM `$this->dbname`.`$this->tbname` WHERE `name` = :name AND `user` = :user ;";
    return $this->conn->fetchOne($sql, (array)$this) !== '0';
  }
  function select()
  {
    $sql = "SELECT * FROM `$this->dbname`.`$this->tbname` WHERE `name` = :name AND `user` = :user ;";
    $option = $this->conn->fetchAssociative($sql, (array)$this);
    if (!$option) {
      return false;
    }
    $this->__construct($option, $this->conn, $this->db);
  }
  function list($options = array())
  {
    $sql = "";
    if (isset($options["names"]) && array_search("*", $options["names"]) !== FALSE) {
      $sql = "SELECT * FROM `$this->dbname`.`$this->tbname` WHERE `user` IN (0, :user); ORDER BY `user` ;";
    } else if (isset($options["names"]) && is_array($options["names"])) {
      $sql = "SELECT * FROM `$this->dbname`.`$this->tbname` WHERE `user` IN (0, :user) AND `name` IN (:names) ORDER BY `user` ;";
    } else {
      return [];
    }
    $sql = $this->__sql($sql);

    return array_map(function ($item) {
      return new TypechoOptionController($item);
    }, $this->conn->fetchAllAssociative($sql, array("user" => $this->user, "names" => $options["names"]), array("names" => \Doctrine\DBAL\Connection::PARAM_STR_ARRAY)));
  }
  // 新增、更新指定用户下的某个配置
  private $sql_insert = "INSERT INTO `:dbname`.`:tbname`";
  // 更新指定用户下的某个配置
  // private $sql_update = "INSERT UPDATE `:dbname`.`:tbname`";
  // 新增/更新指定用户下的某个配置
  private $sql_replace = "REPLACE INTO `:dbname`.`:tbname` (`name`, `user`, `value`) VALUES (:name, :user, :value) ;";
  // 查询指定用户下的单个/多个配置信息
  private $sql_select = "SELECT * FROM `:dbname`.`:tbname` WHERE `user` IN (0, :user) AND `name` IN (:names) ORDER BY `user` ;";
  // 查询指定用户下的所有配置信息
  private $sql_select_all = "SELECT * FROM `:dbname`.`:tbname` WHERE `user` IN (0, :user); ORDER BY `user` ;";
}
