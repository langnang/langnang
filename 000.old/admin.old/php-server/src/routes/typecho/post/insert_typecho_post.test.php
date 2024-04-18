<?php

require_once __DIR__ . "/../../index.test.php";

$response = Requests::post(API_PATH . "/typecho/post/insert", array(
  "AUTHORIZATION" => "Bearer " . $authCode,
), array(
  "title" => $faker->name(),
  "slug" => $faker->uuid(),
  "type" => $faker->word(),
  "text" => $faker->text(),
  "fields" => [
    [
      "name" => $faker->word(),
      "value" => $faker->sentence(),
    ], [
      "name" => $faker->word(),
      "value" => $faker->sentence(),
    ], [
      "name" => $faker->word(),
      "value" => $faker->sentence(),
    ]
  ],
  "metas" => [
    [
      "name" => $faker->word(),
      "type" => $faker->word(),
    ], [
      "name" => $faker->word(),
      "type" => $faker->word(),
    ], [
      "name" => $faker->word(),
      "type" => $faker->word(),
    ]
  ]
));

// print_r($response->body);
print_r(json_decode($response->body, true));
