<?php

namespace Langnang\Typecho;

/**
 * @package TypechoContentController
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
class TypechoContentController extends TypechoContentModel implements TypechoInterface
{

  public $_statusText;
  /**
   * @method create 创建内容表
   * @return Boolean 执行结果
   */
  function create()
  {
    $sql = "CREATE TABLE `$this->dbname`.`$this->tbname`  (
      `cid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
      `title` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
      `slug` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
      `created` int(10) UNSIGNED NULL DEFAULT 0,
      `modified` int(10) UNSIGNED NULL DEFAULT 0,
      `text` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
      `order` int(10) UNSIGNED NULL DEFAULT 0,
      `authorId` int(10) UNSIGNED NULL DEFAULT 0,
      `template` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
      `type` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'post',
      `status` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'publish',
      `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
      `commentsNum` int(10) UNSIGNED NULL DEFAULT 0,
      `allowComment` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0',
      `allowPing` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0',
      `allowFeed` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0',
      `parent` int(10) UNSIGNED NULL DEFAULT 0,
      PRIMARY KEY (`cid`) USING BTREE,
      UNIQUE INDEX `slug`(`slug`) USING BTREE,
      INDEX `created`(`created`) USING BTREE
    ) ENGINE = InnoDB AUTO_INCREMENT = 0 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;
    ";
    return $this->conn->executeStatement($sql, (array)$this);
  }
  function create_secondary()
  {
  }
  function create_summary()
  {
  }
  /**
   * @method drop 删除内容表
   * @return Boolean 执行结果
   */
  function drop()
  {
    $sql = "DROP TABLE IF EXISTS `$this->dbname`.`$this->tbname`;";
    return $this->conn->executeStatement($sql, (array)$this);
  }
  /**
   * @method insert 新增内容列
   * @return Boolean,Null 执行结果：FALSE （失败） Null（成功）
   */
  function insert()
  {
    $sql = "INSERT INTO `$this->dbname`.`$this->tbname`
    (`title`, `slug`, `created`, `modified`, `text`, `order`, `authorId`, `template`, `type`, `status`, `password`, `commentsNum`, `allowComment`, `allowPing`, `allowFeed`, `parent`)
  VALUES
    (:title, :slug, unix_timestamp(now()), unix_timestamp(now()), CONCAT('<!--markdown-->', :text), :order, :authorId, :template, :type, :status, :password, :commentsNum, :allowComment, :allowPing, :allowFeed, :parent);
  ";
    return $this->conn->executeStatement($sql, (array)$this);
  }
  /**
   * @method delete 删除内容列
   * @return Boolean 执行结果
   */
  function delete()
  {
    $sql = "DELETE FROM `$this->dbname`.`$this->tbname` WHERE `cid` = :cid ;";
    return $this->conn->executeStatement($sql, (array)$this);
  }
  function update()
  {
    $sql = "UPDATE `$this->dbname`.`$this->tbname`
    SET
      `title` = :title,
      `slug` = :slug,
      `modified` = unix_timestamp(now()),
      `text` = CONCAT('<!--markdown-->', :text),
      `order` = :order,
      `authorId` = :authorId,
      `template` = :template,
      `type` = :type,
      `status` = :status,
      `password` = :password,
      `commentsNum` = :commentsNum,
      `allowComment` = :allowComment,
      `allowPing` = :allowPing,
      `allowFeed` = :allowFeed,
      `parent` = :parent
    WHERE
      `cid` = :cid;
    ";
    return $this->conn->executeStatement($sql, (array)$this);
  }
  function replace()
  {
  }
  function count()
  {
    $title = '%' . $this->title . '%';
    $text = '%' . $this->text . '%';

    if ($title != "%%" && $text != "%%") {
      $sql = "SELECT COUNT(*) FROM `$this->dbname`.`$this->tbname` WHERE `title` LIKE :title AND `text` LIKE :text ;";
    } else if ($text != "%%") {
      $sql = "SELECT COUNT(*) FROM `$this->dbname`.`$this->tbname` WHERE `text` LIKE :text ;";
    } else {
      $sql = "SELECT COUNT(*) FROM `$this->dbname`.`$this->tbname` WHERE `title` LIKE :title ;";
    }
    return (int)$this->conn->fetchOne($sql, array("title" => $title, "text" => $text));
  }
  // 校验是否已存在
  function is_exists()
  {
    $sql = "SELECT COUNT(*) FROM `$this->dbname`.`$this->tbname` WHERE `cid` = :cid OR `title` = :title;";
    return $this->conn->fetchOne($sql, (array)$this) !== '0';
  }
  function select()
  {
    $sql = "SELECT * FROM `$this->dbname`.`$this->tbname` WHERE `cid` = :cid ;";
    $content = $this->conn->fetchAssociative($sql, (array)$this);
    if (!$content) {
      return FALSE;
    }
    $this->__construct($content, $this->conn, $this->db);
  }
  function select_cid()
  {
    $sql = "SELECT `cid` FROM `$this->dbname`.`$this->tbname` WHERE `title` = :title ;";
    $cid = $this->conn->fetchOne($sql, (array)$this);
    $this->__set("cid", $cid);
  }
  function list($options = array())
  {
    $title = '%' . $this->title . '%';
    $text = '%' . $this->text . '%';

    // 每页条数
    $size = (int)(isset($options["size"]) ? $options["size"] : 10);
    // 当前页数
    $page = (int)(isset($options["page"]) ? $options["page"] : 1);
    $limit = $size;
    $offset = ($page - 1) * $limit;

    if ($title != "%%" &&  $text != "%%") {
      $sql = "SELECT * FROM `$this->dbname`.`$this->tbname` WHERE `title` LIKE :title AND `text` LIKE :text ORDER BY `modified` DESC LIMIT $limit OFFSET $offset;";
    } else if ($text != "%%") {
      $sql = "SELECT * FROM `$this->dbname`.`$this->tbname` WHERE `text` LIKE :text ORDER BY `modified` DESC LIMIT $limit OFFSET $offset;";
    } else {
      $sql = "SELECT * FROM `$this->dbname`.`$this->tbname` WHERE `title` LIKE :title ORDER BY `modified` DESC LIMIT $limit OFFSET $offset;";
    }
    return array_map(function ($item) {
      return new TypechoContentController($item);
    }, $this->conn->fetchAllAssociative($sql, array(
      "title" => $title,
      "text" => $text
    )));
  }
  function random($options = array())
  {
    $num = (int)(isset($options["num"]) ? $options["num"] : 1);
    $sql = "SELECT * FROM `$this->dbname`.`$this->tbname`
    WHERE
      `cid` >= (( SELECT MAX( `cid` ) FROM `$this->dbname`.`$this->tbname` ) - ( SELECT MIN( `cid` ) FROM `$this->dbname`.`$this->tbname` )) * RAND() + ( SELECT MIN( `cid` ) FROM `$this->dbname`.`$this->tbname` )
    LIMIT $num
    ";
    return array_map(function ($item) {
      return new TypechoContentController($item);
    }, $this->conn->fetchAllAssociative($sql, (array)$this));
  }
}
