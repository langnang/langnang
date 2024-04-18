<?php

use QL\QueryList;

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
function test_crawler_querylist($data)
{
  $config = $data["post"];
  if (!isset($config["urls"]) || sizeof($config["urls"]) == 0) {
    return "未定义目标地址(urls)";
  }

  $result = [];
  // 执行
  foreach ($config["urls"] as $url) {
    $ql = QueryList::get($url);
    $res = [];
    foreach ($config["rules"] as $key => $rule) {
      // 过滤没有名称的
      if (!isset($rule["name"])) continue;
      $key = $rule["name"];
      $children = isset($rule["children"]) ? $rule["children"] : null;
      $rule["repeated"] = isset($rule["repeated"]) ? $rule["repeated"] : false;

      if ($children) {
        $child_res = [];
        foreach ($children as $child) {
          if ($rule["repeated"]) {
            $child_res[$child["name"]] = $ql->find($child["selector"])->map(function ($item) {
              return test_crawler_attr($item, $GLOBALS["child"])->all();
            });
          } else {
            $child_res[$child["name"]] = test_crawler_attr($ql, $child);
          }
        }
        $res[$key] = $child_res;
      } else {
        $res[$key] = test_crawler_attr_querylist($ql, $rule);
      }
    }
    array_push($result, $res);
  }
  return array(
    "rows" => $result
  );
}
function test_crawler_attr_querylist($ql, $rule)
{
  $rule["selector"] = isset($rule["selector"]) ? $rule["selector"] : null;
  $rule["attr"] = isset($rule["attr"]) ? $rule["attr"] : "text";
  $rule["filter"] = isset($rule["filter"]) ? $rule["filter"] : null;
  $rule["repeated"] = isset($rule["repeated"]) ? $rule["repeated"] : false;
  $rule["eq"] = (int)(isset($rule["eq"]) ? $rule["eq"] : 0);

  // 特殊属性 text,html
  if ($rule["attr"] == "text" || $rule["attr"] == "html") {
    if ($rule["repeated"]) {
      return  $ql->find($rule["selector"])->{$rule["attr"] . 's'}();
    } else {
      return  $ql->find($rule["selector"])->eq($rule["eq"])->{$rule["attr"]}();
    }
  }
  //
  else {
    if ($rule["repeated"]) {
      return  $ql->find($rule["selector"])->{'attrs'}($rule["attr"]);
    } else {
      return  $ql->find($rule["selector"])->eq($rule["eq"])->{'attr'}($rule["attr"]);
    }
  }
}
