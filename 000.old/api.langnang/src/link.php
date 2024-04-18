<?php
/*
 * @Descripttion:
 * @version:
 * @Author: Langnang
 * @Date: 2021-05-21 11:31:56
 * @LastEditors: Langnang
 * @LastEditTime: 2021-05-22 13:15:26
 */

use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="link",
 *     description="导航链接",
 * )
 */

/**
 * Class LinkModel
 * @OA\Schema(
 *     title="link model",
 *     description="link model",
 * )
 */
class linkModel
{
  public $id;
  public $title;
  /**
   * @OA\Property{
   *     description="地址",
   *     title="Url",
   * }
   * @var string
   */
  public $count;
  /**
   * @OA\Property{
   *     description="名称",
   *     title="Name",
   * }
   * @var string
   */
  public $name;
  /**
   * @OA\Property{
   *     description="描述",
   *     title="Descrition",
   * }
   * @var string
   */
  public $descrition;
  /**
   * @OA\Property{
   *     description="图标",
   *     title="Icon",
   * }
   * @var string
   */
  public $logo;
}

/**
 * @OA\Get (
 *     path="/links",
 *     tags={"link"},
 *     summary="查询列表",
 *     @OA\Parameter(
 *         name="category",
 *         in="query",
 *         description="分类",
 *         @OA\Schema(
 *             type="string",
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="tag",
 *         in="query",
 *         description="标签",
 *         @OA\Schema(
 *             type="string",
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="pageSize",
 *         in="query",
 *         description="单页条数",
 *         @OA\Schema(
 *             type="string",
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="pageNum",
 *         in="query",
 *         description="页码",
 *         @OA\Schema(
 *             type="string",
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 * )
 */
$route->addRoute("GET", "/links", function ($vars) {
  $category = isset($_GET["category"]) ? $_GET["category"] : "";
  $tag = isset($_GET["tag"]) ? $_GET["tag"] : '';
  $page_num = isset($_GET["pageNum"]) ? (int)$_GET["pageNum"] : 1;
  $page_size = isset($_GET["pageSize"]) ? (int)$_GET["pageSize"] : 20;
  $conn = \Doctrine\DBAL\DriverManager::getConnection($GLOBALS["conf"]["dbs"]["typecho"]);
  return array(
    "status" => 200,
    "statusText" => "Success",
    "data" => array(
      "rows" => $conn->executeQuery($GLOBALS["fs"]->read("./sql/link/get_links.sql"), array($category, $tag, ($page_num - 1) * $page_size, $page_size))->fetchAllAssociative(),
      "total" => $conn->executeQuery($GLOBALS["fs"]->read("./sql/link/get_count_links.sql"), array($category, $tag))->fetchOne(),
    ),
  );
});
/**
 * @OA\Get (
 *     path="/link",
 *     tags={"link"},
 *     summary="查询单条详细信息",
 *     @OA\Parameter(
 *         name="id",
 *         in="query",
 *         description="编号",
 *         @OA\Schema(
 *             type="integer",
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 * )
 */
$route->addRoute("GET", "/link", function ($vars) {
  if (!isset($_GET['id'])) {
    return array(
      "status" => 400,
      "statusText" => "Failed: Missing param of link's id",
    );
  }
  $id = (int)$_GET["id"];
  $conn = \Doctrine\DBAL\DriverManager::getConnection($GLOBALS["conf"]["dbs"]["typecho"]);
  return array(
    "status" => 200,
    "statusText" => "Success",
    "data" => $conn->executeQuery($GLOBALS["fs"]->read("./sql/link/get_link.sql"), array($id))->fetchAssociative(),
  );
});
/**
 * @OA\Put (
 *     path="/link",
 *     tags={"link"},
 *     summary="新增",
 *     @OA\Parameter(
 *         name="category",
 *         in="query",
 *         description="分类",
 *         @OA\Schema(
 *             type="string",
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="tag",
 *         in="query",
 *         description="标签",
 *         @OA\Schema(
 *             type="string",
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 * )
 */
$route->addRoute("PUT", "/link", function ($vars) {
  var_dump($vars);
  var_dump($_POST);

  // $id = (int)$_GET["id"];
  // $conn = \Doctrine\DBAL\DriverManager::getConnection($GLOBALS["conf"]["dbs"]["typecho"]);
  return array(
    "status" => 200,
    "statusText" => "Success",
    // "data" => $conn->executeQuery($GLOBALS["fs"]->read("./sql/link/get_link.sql"), array($id))->fetchAssociative(),
  );
});
/**
 * @OA\Post (
 *     path="/link",
 *     tags={"link"},
 *     summary="修改",
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 * )
 */
/**
 * @OA\Delete (
 *     path="/link",
 *     tags={"link"},
 *     summary="删除",
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 * )
 */
