<?php

namespace Langnang\Typecho;

/**
 * @package TypechoFieldController
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
class TypechoFieldController extends TypechoFieldModel implements TypechoInterface
{
  function create()
  {
    $sql = "CREATE TABLE `$this->dbname`.`$this->tbname`  (
      `cid` int(10) UNSIGNED NOT NULL,
      `name` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
      `type` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'str',
      `str_value` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
      `int_value` int(10) NULL DEFAULT 0,
      `float_value` float NULL DEFAULT 0,
      PRIMARY KEY (`cid`, `name`) USING BTREE,
      INDEX `int_value`(`int_value`) USING BTREE,
      INDEX `float_value`(`float_value`) USING BTREE
    ) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;";
    $this->conn->executeStatement($sql, (array)$this);
  }
  function create_secondary()
  {
  }
  function create_summary()
  {
  }
  function drop()
  {
    $sql = "DROP TABLE IF EXISTS `$this->dbname`.`$this->tbname`;";
    $this->conn->executeStatement($sql, (array)$this);
  }
  function insert()
  {
    $sql = "INSERT INTO `$this->dbname`.`$this->tbname` (`cid`, `name`, `type`, `str_value`, `int_value`, `float_value`)
      VALUES (:cid, :name, :type, :str_value, :int_value, :float_value);
    ";
    return  $this->conn->executeStatement($sql, (array)$this);
  }
  function delete()
  {
    $sql = "DELETE FROM `$this->dbname`.`$this->tbname` WHERE `cid` = :cid ;";
    $this->conn->executeStatement($sql, (array)$this);
  }
  function update()
  {
    $sql = "";
  }
  function replace()
  {
  }

  function count()
  {
  }
  function is_exists()
  {
    $sql = "SELECT COUNT(*) FROM `$this->dbname`.`$this->tbname` WHERE `cid` = :cid AND `name` = :name;";
    return $this->conn->fetchOne($sql, (array)$this) !== '0';
  }
  function select()
  {
    $sql = "SELECT * FROM `$this->dbname`.`$this->tbname` WHERE `cid` = :cid AND `name` = :name ;";
    $field = $this->conn->fetchAssociative($sql, (array)$this);
    if (!$field) {
      return FALSE;
    }
    $this->__construct($field, $this->conn, $this->db);
  }
  // 根据ID查询属性
  // TODO 根据属性名+值查询对应的cid列表
  function list($options = array())
  {
    if (!is_null($this->cid)) {
      $sql = "SELECT * FROM `$this->dbname`.`$this->tbname` WHERE `cid` = :cid ;";
    } else {
      $sql = "SELECT * FROM `$this->dbname`.`$this->tbname` WHERE `name` = :name AND `type` = :type AND `{$this->type}_value` = :{$this->type}_value ;";
    }
    return array_map(function ($item) {
      return new TypechoFieldController($item);
    }, $this->conn->fetchAllAssociative($sql, (array)$this));
  }
}
