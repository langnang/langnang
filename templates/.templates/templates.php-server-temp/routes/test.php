<?php

$router->addGroup("/test", function (FastRoute\RouteCollector $router) {
  /**
   * @OA\Get (
   *     path="/test/faker",
   *     summary="查询模拟测试数据",
   *     @OA\Response(response=200, description="Success")
   * )
   */
  $router->addRoute("GET", "/faker", function ($data) {
    header('Content-Type: application/json');
    $faker = Faker\Factory::create();
    echo json_encode([
      "status" => 200,
      "statusText" => "Success",
      "data" => [
        "row" => [
          "uuid" => $faker->uuid(),
          "name" => $faker->name(),
          "email" => $faker->email(),
          "text" => $faker->text(),
        ]
      ]
    ], JSON_UNESCAPED_UNICODE);
  });
  /**
   * @OA\Get (
   *     path="/test/requests",
   *     summary="查询请求测试数据",
   *     @OA\Response(response=200, description="Success")
   * )
   */
  $router->addRoute("GET", "/requests", function ($data) {
    header('Content-Type: application/json');
    $response = Requests::get("https://api.github.com/orgs/langnang-temp/repos");
    echo json_encode([
      "status" => 200,
      "statusText" => "Success",
      "data" => [
        "row" => [],
        "rows" => json_decode($response->body, true)
      ]
    ], JSON_UNESCAPED_UNICODE);
  });
  /**
   * @OA\Post (
   *     path="/test/ftp",
   *     summary="请求测试链接FTP",
   *     @OA\Response(response=200, description="Success")
   * )
   */
  $router->addRoute("POST", "/ftp", function ($data) {
    $ftp = new \FtpClient\FtpClient();
    $post = $data["post"];
    $ftp->connect($post["server"]);
    $ftp->login($post["username"], $post["password"]);
    var_dump($ftp->scanDir('.', true));
    // echo json_encode([
    //   "status" => 200,
    //   "statusText" => "Success",
    //   "data" => [
    //     "row" => [],
    //     // "rows" => json_decode($response->body, true)
    //   ]
    // ], JSON_UNESCAPED_UNICODE);
  });
});
