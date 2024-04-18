<?php

/**
 * 爬虫执行文件
 * start: php -f PhpSpider.php start {$key} {$mode} {$env}
 * @param id 需要执行的任务
 * @param mode create | insert | update
 * @param env 环境
 */
require_once __DIR__ . '/../../../vendor/autoload.php';

use phpspider\core\phpspider;

// 检测配置ID
if (!isset($argv[2]) || !isset($argv[3]) || !isset($argv[4]) || !isset($argv[5])) {
  // print_r(md5(uniqid(mt_rand(), true)));
  return "变量不足，程序启动失败";
}
$id = (int)$argv[2];
$mode = $argv[3];
$env =  $argv[4];
$server =  $argv[5];
$info_url = "$server/crawler/info";
$update_url = "$server/crawler/update";
$res = Requests::post($info_url, array(), array("ids" => [$id]));

// print_r();
// file_put_contents(__DIR__ . "/.txt", json_encode($res->body));
$response = json_decode($res->body, true);
$config = json_decode($res->body, true)["data"]["rows"][0];
$key = !is_null($config["slug"]) ? $config["slug"] : "phpspider";
// return;
// print $key;
// $key = $argv[2];


/* Do NOT delete this comment */
/* 不要删除这段注释 */
// file_put_contents(__DIR__ . "/._config.json", json_encode($config));
$default_options = require_once(__DIR__ . "/default-options.php");

$configs = array_merge(
  $default_options,
  $config,
  // file_exists(__DIR__ . "/$key.json") ? json_decode(file_get_contents(__DIR__ . "/$key.json"), true) : array()
);

if ($configs["export"]["type"] == 'db' && $mode === 'create') {
  $_db = $configs["db_config"];
  $_db["password"] = $_db["pass"];
  $_db["dbname"] = $_db["name"];
  $_db["driver"] = "pdo_mysql";
  $dbname = $_db["dbname"];
  if (isset($configs["export"]["table"])) {
    $tbname = $configs["export"]["table"];
  } else {
    $configs["export"]["table"] = $key;
    $tbname = $key;
  }

  // 链接数据库
  $conn = \Doctrine\DBAL\DriverManager::getConnection($_db);
  // 安全新建数据库
  $sql = "DROP TABLE IF EXISTS `$dbname`.`$tbname`;\n";
  $sql .= "CREATE TABLE `$dbname`.`$tbname`  (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (`id`) USING BTREE
  ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;
  ";
  $conn->executeStatement($sql);

  foreach ($configs["fields"] as $field) {
    if (!isset($field["name"]) || $field["name"] == "") {
      continue;
    }
    $name = $field["name"];
    $sql = "ALTER TABLE `$dbname`.`$tbname` ADD COLUMN `$name` text NULL ;";
    $conn->executeStatement($sql);
  }
}
// file_put_contents(__DIR__ . "/.config.json", json_encode($configs));
$spider = new phpspider($configs);

// 爬虫初始化时调用, 用来指定一些爬取前的操作
// @param $phpspider 爬虫对象
$spider->on_start = function ($phpspider) use ($update_url, $id) {
  // 更新状态
  Requests::post($update_url, array("Content-Type" => "application/json"), json_encode(array("id" => $id, "status" => 9)));
};
// 判断当前网页是否被反爬虫了, 需要开发者实现

// @param $status_code 当前网页的请求返回的HTTP状态码
// @param $url 当前网页URL
// @param $content 当前网页内容
// @param $phpspider 爬虫对象
// @return $content 返回处理后的网页内容，不处理当前页面请返回false


$spider->on_status_code = function ($status_code, $url, $content, $phpspider) {
  // 如果状态码为429，说明对方网站设置了不让同一个客户端同时请求太多次
  if ($status_code == '429') {
    // 将url插入待爬的队列中,等待再次爬取
    $phpspider->add_url($url);
    // 当前页先不处理了
    return false;
  }
  // 不拦截的状态码这里记得要返回，否则后面内容就都空了
  return $content;
};
// 判断当前网页是否被反爬虫了, 需要开发者实现

// @param $url 当前网页的url
// @param $content 当前网页内容
// @param $phpspider 爬虫对象
// @return 如果被反爬虫了, 返回true, 否则返回false


$spider->is_anti_spider = function ($url, $content, $phpspider) {
  // $content中包含"404页面不存在"字符串
  if (strpos($content, "404页面不存在") !== false) {
    // 如果使用了代理IP，IP切换需要时间，这里可以添加到队列等下次换了IP再抓取
    // $phpspider->add_url($url);
    return true; // 告诉框架网页被反爬虫了，不要继续处理它
  }
  // 当前页面没有被反爬虫，可以继续处理
  return false;
};
// 在一个网页下载完成之后调用. 主要用来对下载的网页进行处理.

// @param $page 当前下载的网页页面的对象
// @param $phpspider 爬虫对象
// @return 返回处理后的网页内容

// @param $page['url'] 当前网页的URL
// @param $page['raw'] 当前网页的内容
// @param $page['request'] 当前网页的请求对象
$spider->on_download_page = function ($page, $phpspider) {
  file_put_contents(__DIR__ . "/.txt", $page["raw"]);
  return $page;
};

/**
 * on_download_attached_page($content, $phpspider)
 * 在一个网页下载完成之后调用. 主要用来对下载的网页进行处理.
 * @param $content 当前下载的网页内容
 * @param $phpspider 爬虫对象
 * @return 返回处理后的网页内容
 */
$spider->on_download_attached_page = function ($content, $phpspider) {
  return $content;
};
// 当一个field的内容被抽取到后进行的回调, 在此回调中可以对网页中抽取的内容作进一步处理

// @param $fieldname 当前field的name. 注意: 子field的name会带着父field的name, 通过.连接.
// @param $data 当前field抽取到的数据. 如果该field是repeated, data为数组类型, 否则是String
// @param $page 当前下载的网页页面的对象
// @return 返回处理后的数据, 注意数据类型需要跟传进来的$data类型匹配

// @param $page['url'] 当前网页的URL
// @param $page['raw'] 当前网页的内容
// @param $page['request'] 当前网页的请求对象

$spider->on_extract_field = function ($fieldname, $data, $page) {
  // 转字符串，便于存储
  if (is_array($data)) {
    return json_encode($data, JSON_UNESCAPED_UNICODE);
  }
  // 非空直接返回
  if ($data != "") {
    return $data;
  }
  // 检索判断是否存在替换的原始数据
  $fields = array_filter($GLOBALS["configs"]["fields"], function ($e) use (&$fieldname) {
    return $e["name"] == $fieldname;
  });
  $field = array_shift($fields);
  // 不存在直接返回
  if (!isset($field["param"])) return $data;

  $param = $field["param"];
  switch ($param) {
    case "url":
      $data = $page["url"];
      break;
    case "raw":
      $data = $page["raw"];
      break;
    case "request":
      $data = json_encode($page["request"], JSON_UNESCAPED_UNICODE);
      break;
    case "now":
      $data = time();
      break;
    default:
      break;
  };
  return $data;
};
// 在一个网页的所有field抽取完成之后, 可能需要对field进一步处理, 以发布到自己的网站

// @param $page 当前下载的网页页面的对象
// @param $data 当前网页抽取出来的所有field的数据
// @return 返回处理后的数据, 注意数据类型需要跟传进来的$data类型匹配

// @param $page['url'] 当前网页的URL
// @param $page['raw'] 当前网页的内容
// @param $page['request'] 当前网页的请求对象
$spider->on_extract_page = function ($page, $data) {
  return $data;
};

$spider->start();
