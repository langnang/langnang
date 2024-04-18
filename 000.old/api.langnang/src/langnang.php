<?php

use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="langnang",
 *     description="Langnang",
 * )
 */
$route->addGroup("/langnang", function (FastRoute\RouteCollector $route) {
  /**
   * @OA\Get (
   *     path="/langnang",
   *     tags={"langnang"},
   *     summary="查询基本信息 - 简历、站点",
   *     @OA\Response(response=200, description="Success"),
   * )
   */
  $route->addRoute("GET", "", function ($vas) {
    $repos = json_decode(Requests::get("https://api.github.com/users/langnang/repos")->body);
    $gists = json_decode(Requests::get("https://api.github.com/users/langnang/gists")->body);
    return array(
      "status" => 200,
      "statusText" => "Success",
      "data" => array(
        "basic" => array(
          "name" => "陈朗朗",
          "phone" => "17315764248",
          "email" => "langnang.chen@outlook.com",
        ),
        "gists" => $gists,
        "repos" => $repos,
        "sites" => array(
          array(
            "name" => "langnang.ml",
            "url" => "",
            "keywords" => array("langnang"),
            "title" => "",
            "status" => "",
          ),
          array(
            "name" => "public-apis.langnang",
            "url" => "",
            "desc" => "Public APIs",
            "keywords" => array("public", "api", "langnang"),
            "title" => "",
            "status" => "",
          ),
          array(
            "name" => "api.langnang",
            "url" => "",
            "desc" => "APIs for langnang",
            "keywords" => array("api", "langnang"),
            "title" => "",
            "status" => "",
          ),
          array(
            "name" => "nav.langnang",
            "url" => "",
            "desc" => "",
            "keywords" => array("langnang", "nav"),
            "title" => "",
            "status" => "",
          ),
          array(
            "name" => "blog.langnang",
            "url" => "",
            "desc" => "",
            "keywords" => array("langnang", "blog"),
            "title" => "",
            "status" => "",
          ),
          array(
            "name" => "img-oneindex.langnang",
            "url" => "",
            "desc" => "",
            "keywords" => array("langnang", "onedrive", "oneindex", "img"),
            "title" => "",
            "status" => "",
          ),
        ),
        "third" => array(),
      ),
    );
  });
});
