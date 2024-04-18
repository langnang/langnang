<?php

use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="user",
 *     description="用户信息",
 * )
 */

/**
 * Class UserModel
 *
 * @OA\Schema(
 *     title="User model",
 *     description="User model",
 * )
 */
class UserModel
{
  /**
   * @OA\Property(
   *     description="编号",
   *     title="ID",
   * )
   * @var integer
   */
  public $id;
  /**
   * @OA\Property(
   *     description="唯一识别码",
   *     title="UUID",
   * )
   * @var string
   */
  public $uuid;
  /**
   * @OA\Property(
   *     description="姓名",
   *     title="Name",
   * )
   * @var string
   */
  public $name;
  /**
   * 姓
   * @var string
   * @OA\Property(
   *     description="姓",
   *     title="firstname",
   * )
   */
  public $firstname;
  /**
   * 名
   * @var string
   * @OA\Property(
   *     description="名",
   * )
   */
  public $lastname;
  /**
   * 居住地址
   * @var string
   * @OA\Property()
   */
  public $address;
  /**
   * 邮箱地址
   * @var string
   * @OA\Property()
   */
  public $email;
  /**
   * 手机号码
   * @var string
   * @OA\Property()
   */
  public $phone;
  /**
   * 所属公司
   * @var string
   * @OA\Property()
   */
  public $company;
  /**
   * 工作，身份
   * @var string
   * @OA\Property()
   */
  public $job;

  function __construct($data = array())
  {

    $faker = $GLOBALS["faker"];
    $this->id = array_key_exists("id", $data) ? $data["id"] : $faker->unique()->randomNumber(9, false);
    $this->uuid = array_key_exists("uuid", $data) ? $data["uuid"] : $faker->uuid();
    $this->name = array_key_exists("name", $data) ? $data["name"] : $faker->name();
    $this->address = array_key_exists("address", $data) ? $data["address"] : $faker->address();
    $this->email = array_key_exists("email", $data) ? $data["email"] : $faker->email();
    $this->phone = array_key_exists("phone", $data) ? $data["phone"] : $faker->phoneNumber();
    $this->company = array_key_exists("company", $data) ? $data["company"] : $faker->company();
    $this->job = array_key_exists("job", $data) ? $data["job"] : $faker->jobTitle();
  }
}

/**
 * @OA\Get (
 *     path="/users",
 *     tags={"user"},
 *     summary="查询列表",
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Not Found"
 *     ),
 *     @OA\Response(
 *         response=405,
 *         description="Method Not Allowed"
 *     ),
 * )
 */
$route->addRoute("GET", "/users", function ($var) {
  $res = array(
    "desc" => "get user list",
    "status" => 200,
    "statusText" => "Success",
    "data" => array(
      "rows" => array(),
      "total" => $GLOBALS["faker"]->randomNumber(6, false)
    ),
  );
  for ($i = 0; $i < 20; $i++) {
    array_push($res["data"]["rows"], new UserModel());
  }
  return $res;
});
/**
 * @OA\Get (
 *     path="/user",
 *     tags={"user"},
 *     summary="查询单个信息",
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Not Found"
 *     ),
 *     @OA\Response(
 *         response=405,
 *         description="Method Not Allowed"
 *     ),
 * )
 */
$route->addRoute("GET", "/user", function ($var) {
  $res = array(
    "desc" => "get user info",
    "status" => 200,
    "statusText" => "Success",
    "data" => array(),
  );
  return $res;
});
/**
 * @OA\Post (
 *     path="/user",
 *     tags={"user"},
 *     summary="新增",
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Not Found"
 *     ),
 *     @OA\Response(
 *         response=405,
 *         description="Method Not Allowed"
 *     ),
 * )
 */
$route->addRoute("POST", "/user", function ($var) {
  $res = array(
    "status" => 200,
    "statusText" => "Success",
    "data" => array(),
  );
  return $res;
});
/**
 * @OA\Put (
 *     path="/user",
 *     tags={"user"},
 *     summary="更新",
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Not Found"
 *     ),
 *     @OA\Response(
 *         response=405,
 *         description="Method Not Allowed"
 *     ),
 * )
 */
$route->addRoute("PUT", "/user", function ($var) {
  $res = array(
    "status" => 200,
    "statusText" => "Success",
    "data" => array(),
  );
  return $res;
});
/**
 * @method DELETE
 * @url /user
 * @desc 删除
 */
/**
 * @OA\Delete (
 *     path="/user",
 *     tags={"user"},
 *     summary="更新",
 *     @OA\Response(
 *         response=200,
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Not Found"
 *     ),
 *     @OA\Response(
 *         response=405,
 *         description="Method Not Allowed"
 *     ),
 * )
 */
$route->addRoute("DELETE", "/user", function ($var) {
  $res = array(
    "status" => 200,
    "statusText" => "Success",
    "data" => array(),
  );
  return $res;
});
