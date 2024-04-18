<?php

namespace Langnang\Component\Crawler;

use Langnang\Component\Template\TemplateModel;
use phpspider\core\phpspider;
use phpspider\core\requests;
use phpspider\core\selector;

class CrawlerModel extends TemplateModel
{
  //
  public $id;
  // 名称
  public $name;
  // 别名
  public $slug;
  public $export;
  public $db_config = array(
    'host'  => '127.0.0.1',
    'port'  => 3306,
    'user'  => 'develop',
    'pass'  => 'develop',
    'name'  => 'develop',
  );
  // 域名
  public $domains = [];
  // 扫描的地址入口
  public $scan_urls = [];
  // 正则匹配的内容页
  public $content_url_regexes = [];
  // 正则匹配的目录页
  public $list_url_regexes = [];
  // 提取参数规则
  public $fields = [];
  // 状态，-1：异常，0：停止，1：排队，9：运行中...
  public $status = 0;
  public $statusText = '停止';
  // collectSuccess
  // collectFail
  // findPages
  // queue
  // collected
  // fields
  // depth 递归深度
  // Typecho对应的文章数据
  public $_post;

  function construct($model, ...$args)
  {
  }

  function setStatus($value)
  {
    $this->status = (int)$value;
    $this->setStatusText();
  }
  function setStatusText()
  {
    $statusOptions = array(
      array(
        "status" => -9,
        "statusText" => "异常"
      ),
      array(
        "status" => -1,
        "statusText" => "停止中"
      ),
      array(
        "status" => 0,
        "statusText" => "停止"
      ),
      array(
        "status" => 1,
        "statusText" => "排队"
      ),
      array(
        "status" => 9,
        "statusText" => "运行中"
      ),
    );
    foreach ($statusOptions as $item) {
      if ($item["status"] == $this->status) {
        $this->statusText = $item["statusText"];
        return;
      }
    }
  }
}

class CrawlerController extends CrawlerModel
{
  function execute()
  {
  }

  static function insert($data)
  {
    $db = array("prefix" => "typecho_crawler_");
    $post = $data["post"];
    $post["title"] = $post["name"];
    $post["text"] = json_encode($post, JSON_UNESCAPED_UNICODE);
    $data["post"] = $post;
    return insert_typecho_post($data, $db);
  }
  function delete()
  {
  }
  function update()
  {
  }
  function select()
  {
  }
  static function test($data)
  {
    $config = $data["post"];
    if (!isset($config["scan_urls"]) || sizeof($config["scan_urls"]) == 0) {
      return "未定义目标地址(scan_urls)";
    }

    $scan_urls = $config["scan_urls"];
    $fields = $config["fields"];
    $result = [];
    // 执行
    foreach ($scan_urls as $url) {
      $html = requests::get($url);

      $row = [];
      foreach ($fields as $field) {
        $row[$field["name"]] = selector::select($html, $field["selector"]);
      }
      array_push($result, $row);
    }

    return array(
      "rows" => $result
    );
  }

  //
  static function from_typecho_post($post)
  {
    $crawler = new CrawlerController(
      array_merge(
        json_decode($post->text, true),
        array(
          "id" => $post->cid,
          "name" => $post->title,
          "slug" => $post->slug,
          "_post" => $post,
        )
      )
    );
    foreach ($post->fields as $field) {
      if (array_search($field->name, ["status"]) !== FALSE) {
        $crawler->__set($field->name, $field->int_value);
      }
    }
    return $crawler;
  }
  // Crawler Convert to Typecho Post
  static function to_typecho_post($crawler)
  {
    $post = array_merge(
      (array)$crawler["_post"],
      array(
        "fields" => array(
          array(
            "name" => "status",
            "value" => $crawler["status"],
          )
        ),
      )
    );
    return $post;
  }
}


class CrawlerRuleModel
{
  public $name;
  public $selector;
}
