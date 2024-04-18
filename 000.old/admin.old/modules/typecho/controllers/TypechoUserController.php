<?php

namespace Langnang\Typecho;

use Langnang\Typecho\TypechoInterface;

/**
 * @package TypechoUserController
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
class TypechoUserController extends TypechoUserModel implements TypechoInterface
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
  }
  function delete()
  {
  }
  function update()
  {
  }
  function replace()
  {
  }
  function count()
  {
  }
  function is_exists()
  {
  }
  function select($options = array())
  {
    if (isset($options["authCode"])) {
      $sql = $this->__sql($this->sql_select_by_authcode, array(
        ":authCode" => $options["authCode"],
      ));
    } else if (!is_null($this->uid)) {
      $sql = "SELECT * FROM `$this->dbname`.`$this->tbname` WHERE `uid` = :uid ;";
    } else {
      return FALSE;
    }
    $user = $this->conn->fetchAssociative($sql, (array)$this);
    if ($user === FALSE) {
      return FALSE;
    }
    $this->__construct($user, $this->conn, $this->db);
  }
  function login($options = array())
  {
    $authCode = md5(uniqid(mt_rand(), true));
    $sql = $this->__sql($this->sql_update_autocode, array(
      ":password" => $options["password"],
      ":authCode" => $authCode,
    ));
    $state = $this->conn->executeStatement($sql, (array)$this);
    if ($state === 0) return FALSE;

    return $authCode;
  }
  function logout()
  {
  }
  function list($options = array())
  {
    if (is_null($this->user)) {
      $this->user = 0;
    }
    $sql = "SELECT * FROM `$this->dbname`.`$this->tbname` WHERE `user` = :user;";
    return array_map(function ($item) {
      return new TypechoUserController($item);
    }, $this->conn->fetchAllAssociative($sql, (array)$this));
  }
  // 新增
  private $sql_insert = "INSERT INTO `:dbname`.`:tbname`
    (`uid`, `name`, `password`, `mail`, `url`, `screenName`, `created`, `activated`, `logged`, `group`, `authCode`)
  VALUES
    (:uid, :name, :password, :mail, :url, :screenName, :created, :activated, :logged, :group, :authCode)
  ;";
  private $sql_delete = "DELETE `:dbname`.`:tbname`
  WHERE `uid` = :uid OR `uid` IN (:uids)
  ;";
  // 更新
  private $sql_update = "UPDATE `:dbname`.`:tbname`
  SET
    `name` = :name,
    `password` = :password,
    `mail` = :mail,
    `url` = :url,
    `screenName` = :screenName,
    `created` = :created,
    `activated` = :activated,
    `logged` = :logged,
    `group` = :group,
    `authCode` = :authCode,
  WHERE `uid` = :uid
  ;";
  //
  private $sql_update_autocode = "UPDATE `:dbname`.`:tbname`
  SET
    `authCode` = ':authCode',
    `activated` = unix_timestamp(now())
  WHERE
    `name` = :name
  AND
    `password` = ':password'
  LIMIT 1
  ;";
  // 重置验证令牌，用于登出
  private $sql_update_autocode_null = "UPDATE `:dbname`.`:tbname`
  SET
    `authCode` = null
  WHERE `authCode` = :authCode
  ;";
  // 根据账号密码查询，一般用于登录
  private $sql_select_by_user_pass = "SELECT * FROM `:dbname`.`:tbname`
  WHERE
    `name` = :name
  AND
    `password` = :password
  LIMIT 1
  ;";
  // 根据验证令牌查询，一般用于权限验证
  private $sql_select_by_authcode = "SELECT * FROM `:dbname`.`:tbname`
  WHERE
    `authCode` = ':authCode'
  LIMIT 1
  ;";
}
