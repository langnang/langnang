<?php

namespace Langnang\Typecho;

/**
 * @package TypechoRelationshipController
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
class  TypechoRelationshipController extends TypechoRelationshipMotel implements TypechoInterface
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
    $sql = "INSERT INTO `$this->dbname`.`$this->tbname` (`cid`, `mid`) VALUES (:cid, :mid);";
    return $this->conn->executeStatement($sql, (array)$this);
  }
  function delete()
  {
    if (!is_null($this->cid) && !is_null($this->mid)) {
      $sql = "DELETE FROM `$this->dbname`.`$this->tbname` WHERE `cid` = :cid AND `mid` = :mid;";
    } else if (!is_null($this->cid)) {
      $sql = "DELETE FROM `$this->dbname`.`$this->tbname` WHERE `cid` = :cid ;";
    } else {
      $sql = "DELETE FROM `$this->dbname`.`$this->tbname` WHERE `mid` = :mid ;";
    }
    return $this->conn->executeStatement($sql, (array)$this);
  }
  function update()
  {
  }
  function replace()
  {
  }

  function count()
  {
    if (is_null($this->cid)) {
      $sql = "SELECT COUNT(*) FROM `$this->dbname`.`$this->tbname` WHERE `mid` = :mid ;";
    } else if (is_null($this->mid)) {
      $sql = "SELECT COUNT(*) FROM `$this->dbname`.`$this->tbname` WHERE `cid` = :cid ;";
    } else {
      return;
    }
    return (int)$this->conn->fetchOne($sql);
  }
  function is_exists()
  {
    $sql = "SELECT COUNT(*) FROM `$this->dbname`.`$this->tbname` WHERE `cid` = :cid AND `mid` = :mid ;";
    return $this->conn->fetchOne($sql, (array)$this) !== '0';
  }
  function select()
  {
    $sql = "SELECT * FROM `$this->dbname`.`$this->tbname` WHERE `cid` = :cid AND `mid` = :mid ;";
    $relationship = $this->conn->fetchAssociative($sql, (array)$this);
    $this->__construct($relationship, $this->conn, $this->db);
  }
  // 查询关联关系
  function list($options = array())
  {
    $cids = [];
    $mids = [];
    if (isset($options["cids"])) {
      $cids = $options["cids"];
      $sql = "SELECT DISTINCT `mid` FROM `$this->dbname`.`$this->tbname` WHERE `cid` IN (:cids) ;";
    } else if (isset($options["mids"])) {
      $mids = $options["mids"];
      $sql = "SELECT DISTINCT `cid` FROM `$this->dbname`.`$this->tbname` WHERE `mid` IN (:mids) ;";
    } else if (is_null($this->cid)) {
      $mids = [$this->mid];
      $sql = "SELECT DISTINCT `cid` FROM `$this->dbname`.`$this->tbname` WHERE `mid` IN (:mids) ;";
    } else if (is_null($this->mid)) {
      $cids = [$this->cid];
      $sql = "SELECT DISTINCT `mid` FROM `$this->dbname`.`$this->tbname` WHERE `cid` IN (:cids) ;";
    } else {
      return FALSE;
    }
    return array_map(function ($item) {
      return new TypechoRelationshipController($item);
    }, $this->conn->fetchAllAssociative($sql, array("mids" => $mids, "cids" => $cids), array("mids" => \Doctrine\DBAL\Connection::PARAM_INT_ARRAY, "cids" => \Doctrine\DBAL\Connection::PARAM_INT_ARRAY)));
  }
}
