<?php

use Langnang\Component\Crawler\CrawlerController;
use phpspider\core\phpspider;
use phpspider\core\requests;
use phpspider\core\selector;

$GLOBALS["ROUTER_PARAMS"]["test_crawler"] = array(
  "post" => array(
    "test_urls" => array(
      "desc" => "页面地址",
      "type" => "array",
      "required" => true,
    ),
    "fields" => array(
      "desc" => "页面数据抽取规则",
      "type" => "array",
      "required" => true,
    ),
  )
);
/**
 * @package config
 *
 * @param id ID
 * @param name 名称
 * @param urls 需要提取数据的网页地址
 * @param rules 提取的数据规则配置
 * * @param name 参数名
 * * @param selector 页面元素选择器
 * * @param eq 元素次序
 * * @param attr 元素属性，默认为text，即元素内容,* 返回所有属性，包括text，html
 * * @param required 必要，即是否可为空
 * * @param repeated 多项，多个结果组成的数组，与 eq 属性互斥，权重 10
 * * @param children 子项，权重 100
 */
function test_crawler_post($data)
{
  function crawler_select_content($html, $fields = array())
  {
    if (sizeof($fields) == 0) return $html;
    $rows = [];
    foreach ($fields as $field) {
      $_html = "";
      if (isset($field["selector"]) && $field["selector"] != "") {
        $_html = selector::select($html, $field["selector"]);
      }
      $rows[$field["name"]] = $_html;
      if (isset($field["children"])) {
        $rows[$field["name"]] = crawler_select_content($_html, $field["children"]);
      }
    }
    return $rows;
  }
  $config = $data["post"];
  $test_urls = $config["test_urls"];
  $fields = $config["fields"];
  $result = [];
  // 执行
  foreach ($test_urls as $url) {
    $html = requests::get($url);
    // $row = [];
    // foreach ($fields as $field) {
    //   $row[$field["name"]] = selector::select($html, $field["selector"]);
    // }
    array_push($result, crawler_select_content($html, $fields));
  }

  return array(
    "rows" => $result,
    "total" => count($result),
  );
}
