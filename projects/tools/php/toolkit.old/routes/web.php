<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  return view('index', [
    "contents" => [
      [
        "name" => "crypto",
        "contents" => array_map(function ($item) {
          return ["title" => $item];
        }, [
          "md5",
          "sha1",
          "sha256",
          "sha224",
          "sha512",
          "sha384",
          "sha3",
          "ripemd160",
          "hmac-md5",
          "hmac-sha1",
          "hmac-sha256",
          "hmac-sha224",
          "hmac-sha512",
          "hmac-sha384",
          "hmac-sha3",
          "hmac-ripemd160",
          "pbkdf2",

          "aes",
          "tripledes",
          "rc4",
          "rabbit",
          "rabbit-legacy",
          "evpkdf",

          "format-openssl",
          "format-hex",

          "enc-latin1",
          "enc-utf8",
          "enc-hex",
          "enc-utf16",
          "enc-base64",

          "mode-cfb",
          "mode-ctr",
          "mode-ctr-gladman",
          "mode-ofb",
          "mode-ecb",

          "pad-pkcs7",
          "pad-ansix923",
          "pad-iso10126",
          "pad-iso97971",
          "pad-zeropadding",
          "pad-nopadding",
        ],),
      ],
      [
        "name" => "Random",
        "contents" => [
          [
            "title" => "Color",
          ]
        ],
      ],
      ["name" => "Editor"],
      ["name" => "Converter"],
      [
        "name" => "Spider",
        "contents" => [
          [
            "slug" => "spider_siteinfo",
            "title" => "SiteInfo",
          ]
        ],
      ],
      [
        "name" => "Other",
        "contents" => [
          [
            "slug" => "other_progress",
            "title" => "Progress",
          ]
        ],
      ]
    ],
    "links" => [
      ["url" => "https://www.julinghu.com/", "title" => "牛站工具网",],
      ["url" => "https://tools.kui.li/", "title" => "奎箱 - 小工具聚集地",],
      ['url' => 'https://cryptojs.gitbook.io/docs/', "title" => "CryptoJS",],
    ],
  ]);
});

Route::match(['get', 'post'], '/{meta}/{content}', function ($meta, $content, Request $request) {
  $data = ["meta" => $meta, "content" => $content, "data" => $request->all(), "refs" => [
    ["title" => "owner888/phpspider", "url" => "https://doc.phpspider.org/",],
    ["title" => "XPath 教程 - W3school", "url" => "https://www.w3school.com.cn/xpath/index.asp"],
  ]];

  if (file_exists(__DIR__ . "/../resources/views/$meta/$content.blade.php")) {
    return view("$meta.$content", $data);
  }
  return $data;
});
