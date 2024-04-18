<?php
/*
 * @Descripttion:
 * @version:
 * @Author: Langnang
 * @Date: 2021-05-21 15:25:54
 * @LastEditors: Langnang
 * @LastEditTime: 2021-05-25 11:07:49
 */

use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="fake",
 *     description="模拟数据",
 * )
 */

/**
 * Class fakeModel
 * @OA\Schema(
 *     title="fake model",
 *     description="fake model",
 * )
 */
class fakeModel
{
  /**
   * @OA\Property{
   *     description="统计的人数",
   *     title="Count",
   * }
   * @var integer
   */
  public $count;
  /**
   * @OA\Property{
   *     description="统计的人数",
   *     title="Count",
   * }
   * @var integer
   */
  public $year;
}

/**
 * @OA\Get (
 *     path="/fakes",
 *     tags={"fake"},
 *     summary="查询列表",
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 * )
 */
$route->addRoute("GET", '/fakes', function ($var) {
  $faker = $GLOBALS["faker"];
  var_dump($var);
  $res = array(
    "desc" => "get user info",
    "status" => 200,
    "statusText" => "Success",
    "data" => array(
      "rows" => array(),
      "total" => 0,
    ),
  );
  return $res;
});
/**
 * @OA\Get (
 *     path="/fake",
 *     tags={"fake"},
 *     summary="查询单条详细信息",
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 * )
 */
/**
 * @OA\Put (
 *     path="/fake",
 *     tags={"fake"},
 *     summary="新增",
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 * )
 */
/**
 * @OA\Post (
 *     path="/fake",
 *     tags={"fake"},
 *     summary="修改",
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 * )
 */
/**
 * @OA\Delete (
 *     path="/fake",
 *     tags={"fake"},
 *     summary="删除",
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 * )
 */
