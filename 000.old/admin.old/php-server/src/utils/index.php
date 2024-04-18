<?php

/**
 * 路由请求数据中的参数检测
 */
function router_params_exists($handler)
{
  /**
   * 参数检测与设置默认值
   */
  function params_exists($key, $data, $config, ...$parent_keys)
  {
    // 必要性检测：检测参数是否存在
    if (array_key_exists("required", $config) && $config["required"] === TRUE) {
      if (!array_key_exists($key, $data)) {
        // 设置默认值
        // 数据中不存在该参数
        // 且必要
        // 配置中设置参数的默认值
        if (array_key_exists("default", $config)) {
          switch (sizeof($parent_keys)) {
            case 0:
              $GLOBALS["request"][$key] = $config["default"];
              break;
            case 1:
              $GLOBALS["request"][$parent_keys[0]][$key] = $config["default"];
              break;
            case 2:
              $GLOBALS["request"][$parent_keys[0]][$parent_keys[1]][$key] = $config["default"];
              break;
            case 3:
              $GLOBALS["request"][$parent_keys[0]][$parent_keys[1]][$parent_keys[2]][$key] = $config["default"];
              break;
            case 4:
              $GLOBALS["request"][$parent_keys[0]][$parent_keys[1]][$parent_keys[2]][$parent_keys[3]][$key] = $config["default"];
              break;
            case 5:
              $GLOBALS["request"][$parent_keys[0]][$parent_keys[1]][$parent_keys[2]][$parent_keys[3]][$parent_keys[4]][$key] = $config["default"];
              break;
            default:
              break;
          }
        } else {
          return "缺少必要的参数（" . $key . "）";
        }
      }
    }
    // 类型检测：数据中存在该参数，配置中设置参数对应的类型
    if (array_key_exists($key, $data) && array_key_exists("type", $config)) {
      // 单个数据类型
      if (is_string($config["type"])) {
        if (!call_user_func('is_' . $config["type"], $data[$key])) {
          return "（" . $key . "）数据类型错误，应为 " . $config["type"] . "";
        }
      }
      // 多个数据类型
      if (is_array($config["type"])) {
        $_type_error = [];
        foreach ($config["type"] as $_key => $_type) {
          // 失败
          if (function_exists('is_' . $_type) && !call_user_func('is_' . $_type, $data[$key])) {
            array_push($_type_error, FALSE);
          }
          // 成功
          else {
            array_push($_type_error, TRUE);
          }
        }
        // 检测是否存在检测结果为成功的
        if (array_search(TRUE, $_type_error) === FALSE) {
          return "（" . $key . "）数据类型错误，应为 " . json_encode($config["type"]) . "";
        }
      }
    }
    // 可选值检测：数据中存在该参数
    // 且设置了可选值范围
    // 可选值为数组，且长度大于0
    // 第一层不处理
    if (array_key_exists($key, $data) && array_key_exists("options", $config) && is_array($config["options"]) && sizeof($config["options"]) > 0 && sizeof($parent_keys) > 0) {
      if (array_search($data[$key], $config["options"], true) === FALSE) {
        return "（" . $key . "）数据值不符合范围";
      }
    }
  }
  $request = $GLOBALS["request"];
  $ROUTER_PARAMS = $GLOBALS["ROUTER_PARAMS"];
  $params = array();
  // 获取路由对应的参数检测配置
  if (is_string($handler) && array_key_exists($handler, $ROUTER_PARAMS)) {
    $params = $ROUTER_PARAMS[$handler];
  } else {
    return TRUE;
  }

  if (sizeof($params) !== 0) {
    // 遍历第一层检测配置，请求方式
    foreach ($params as $_key_1 => $_item_1) {
      // 遍历第二层
      $result = params_exists($_key_1, $request, $_item_1);
      if (is_string($result)) return $result;
      foreach ($_item_1  as $_key_2 => $_item_2) {
        if (!is_array($_item_2)) continue;
        $result = params_exists($_key_2, $request[$_key_1], $_item_2, $_key_1);
        if (is_string($result)) return $result;
      }
    }
  }


  return TRUE;
}
