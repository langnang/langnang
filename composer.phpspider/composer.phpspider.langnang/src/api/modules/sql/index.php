<?

/**
 * @OA\Info(
 *     version="0.0.0",
 *     title="SQL APIs",
 * )
 */
/**
 * @OA\Tag(
 *     name="sql",
 * )
 */


$router->addGroup('/sql', function (FastRoute\RouteCollector $router) use ($_SQL) {
  $conn = \Doctrine\DBAL\DriverManager::getConnection($_ENV['MySQL']);
  $_SQL['$self'] = $_SQL[pathinfo(dirname(__DIR__))['filename']][pathinfo(__FILE__)['filename']];
  /**
   * @OA\Get(
   *     path="/api/sql/connection",
   *     tags={"sql"},
   *     summary="链接数据库",
   *     @OA\Response(response="200", description="")
   * )
   */
  $router->addRoute("GET", "/connection", function () use ($conn) {
    return $conn;
  });
  $router->addGroup("/table", function (FastRoute\RouteCollector $router) use ($conn, $_SQL) {
    /**
     * @OA\Get(
     *     path="/api/sql/table/list",
     *     tags={"sql"},
     *     summary="查询数据库中所有表的信息",
     *     @OA\Response(response="200", description="")
     * )
     */
    $router->addRoute("GET", "/list", function () use ($conn, $_SQL) {
      return [
        "rows" => $conn->fetchAllAssociative(call_user_func_array(
          $_SQL['$self']['select_table_list'],
          get_defined_vars()
        )),
        "total" => (int)$conn->fetchOne(call_user_func_array(
          $_SQL['$self']['select_table_count'],
          get_defined_vars()
        ))
      ];
    });
    /**
     * @OA\Get(
     *     path="/api/sql/table/info",
     *     tags={"sql"},
     *     summary="查询数据库中单个表的信息",
     *     @OA\Parameter(
     *         name="table_name",
     *         in="query",
     *         description="表名",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Response(response="200", description="")
     * )
     */
    $router->addRoute("GET", "/info", function () use ($conn, $_SQL) {
      return $conn->fetchAllAssociative(call_user_func_array(
        $_SQL['$self']['select_table_info'],
        get_defined_vars()
      ));
    });
  });
  $router->addGroup("/column", function (FastRoute\RouteCollector $router) use ($conn, $_SQL) {
    /**
     * @OA\Get(
     *     path="/api/sql/column/list",
     *     tags={"sql"},
     *     summary="查询数据库中表的所有字段信息",
     *     @OA\Parameter(
     *         name="table_name",
     *         in="query",
     *         description="表名",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Response(response="200", description="")
     * )
     */
    $router->addRoute("GET", "/list", function () use ($conn, $_SQL) {
      return [
        "rows" => $conn->fetchAllAssociative(call_user_func_array(
          $_SQL['$self']['select_column_list'],
          get_defined_vars()
        )),
        "total" => (int)$conn->fetchOne(call_user_func_array(
          $_SQL['$self']['select_column_count'],
          get_defined_vars()
        ))
      ];
    });
    /**
     * @OA\Get(
     *     path="/api/sql/column/info",
     *     tags={"sql"},
     *     summary="查询数据库中表的所有字段信息",
     *     @OA\Parameter(
     *         name="table_name",
     *         in="query",
     *         description="表名",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="column_name",
     *         in="query",
     *         description="列名",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Response(response="200", description="")
     * )
     */
    $router->addRoute("GET", "/info", function () use ($conn, $_SQL) {
      return $conn->fetchAllAssociative(call_user_func_array(
        $_SQL['$self']['select_column_info'],
        get_defined_vars()
      ));
    });
  });
});
