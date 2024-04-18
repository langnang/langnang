<?php

namespace Langnang\Typecho;

use Langnang\Component\SQL\SqlController;
use Langnang\Typecho\TypechoMetaInterface;

/**
 * @package TypechoMetaController
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
class TypechoMetaController extends TypechoMetaModel implements TypechoMetaInterface
{
  function create()
  {
  }
  function create_secondary()
  {
  }
  function create_summary()
  {
  }
  function drop()
  {
  }
  function insert()
  {
    $sql = "INSERT INTO `$this->dbname`.`$this->tbname`
        (`name`, `slug`, `type`, `description`, `count`, `order`, `parent`)
      VALUES
        (:name, :slug, :type, :description, :count, :order, :parent);
      ";
    return $this->conn->executeStatement($sql, (array)$this);
  }
  function delete()
  {
    $sql = "DELETE FROM `$this->dbname`.`$this->tbname` WHERE `mid` = :mid ;";
    return $this->conn->executeStatement($sql, (array)$this);
  }
  /**
   * 根据ID更新全部/部分标识
   * @method update
   * @return Boolean
   */
  function update()
  {
    $sql = "UPDATE `$this->dbname`.`$this->tbname`
    SET
      `name` = :name,
      `slug` = :slug,
      `type` = :type,
      `description` = :description,
      `count` = :count,
      `order` = :order,
      `parent` = :parent
    WHERE
      `mid` = :mid;
    ";
    return $this->conn->executeStatement($sql, (array)$this);
  }
  function replace()
  {
    $sql = "REPLACE INTO `$this->dbname`.`$this->tbname`
      (`mid`, `name`, `slug`, `type`, `description`, `count`, `order`, `parent`)
    VALUES
      (:mid, :name, :slug, :type, :description, :count, :order, :parent); ;";
    if ($this->conn->executeStatement($sql, (array)$this) === FALSE) {
      return "Failed to replace data."; // 替换操作失败
    }
    if (is_null($this->mid)) {
      $this->select_mid(); // 查询ID
    }
  }

  function count()
  {
    $conditions = [];
    array_push($conditions, array(
      "name" => "name",
      "condition" => "LIKE",
      "value" => '%' . $this->name . '%'
    ));
    if (!is_null($this->type)) {
      array_push($conditions, array(
        "name" => "type",
        "condition" => "=",
        "value" => $this->type
      ));
    }
    if (!is_null($this->parent)) {
      array_push($conditions, array(
        "name" => "parent",
        "condition" => "=",
        "value" => $this->parent
      ));
    }
    $sql_condition = SqlController::sql_condition($conditions);
    $sql = "SELECT COUNT(*) FROM	`$this->dbname`.`$this->tbname` $sql_condition ;";
    return (int)$this->conn->fetchOne($sql);
  }
  function is_exists()
  {
    $sql = "SELECT COUNT(*) FROM `$this->dbname`.`$this->tbname` WHERE `name` = :name AND `type` = :type ;";
    return $this->conn->fetchOne($sql, (array)$this) !== '0';
  }
  function select()
  {
    $sql = "SELECT * FROM `$this->dbname`.`$this->tbname` WHERE `mid` = :mid ;";
    $meta = $this->conn->fetchAssociative($sql, (array)$this);
    if (!$meta) {
      return false;
    }
    $this->__construct($meta, $this->conn, $this->db);
  }
  function select_mid()
  {
    $sql = "SELECT `mid` FROM `$this->dbname`.`$this->tbname` WHERE `name` = :name AND `type` = :type ;";
    $mid = $this->conn->fetchOne($sql, (array)$this);
    $this->__set("mid", $mid);
  }
  /**
   * 列表查询
   * * 类型查询
   * * 名称模糊查询
   * * 上一级查询
   */
  function list($options = array())
  {
    $conditions = [];
    array_push($conditions, array(
      "name" => "name",
      "condition" => "LIKE",
      "value" => '%' . $this->name . '%'
    ));
    if (!is_null($this->type)) {
      array_push($conditions, array(
        "name" => "type",
        "condition" => "=",
        "value" => $this->type
      ));
    }
    if (!is_null($this->parent) && $this->parent !== 0) {
      array_push($conditions, array(
        "name" => "parent",
        "condition" => "=",
        "value" => $this->parent
      ));
    }
    $sql_condition = SqlController::sql_condition($conditions);
    // 每页条数
    $size = (int)(isset($options["size"]) ? $options["size"] : 10);
    // 当前页数
    $page = (int)(isset($options["page"]) ? $options["page"] : 1);
    $limit = $size;
    $offset = ($page - 1) * $limit;

    $sql = "SELECT * FROM	`$this->dbname`.`$this->tbname` $sql_condition LIMIT $limit OFFSET $offset;";

    return array_map(function ($item) {
      return new TypechoMetaController($item);
    }, $this->conn->fetchAllAssociative($sql, array("type" => $this->type, "name" => $this->name)));
  }

  function tree($options = array())
  {
    $list = $this->list($options);
  }

  function type_list()
  {
    $sql = "SELECT DISTINCT `type` FROM `$this->dbname`.`$this->tbname` ;";
    return array_map(function ($item) {
      return new TypechoMetaController($item);
    }, $this->conn->fetchAllAssociative($sql, (array)$this));
  }
}
