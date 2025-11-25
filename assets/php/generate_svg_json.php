<?php
/**
 * 生成 SVG 数据文件
 * @path /storage/php/generate/generate_svg_json.php
 * @return array
 */
class Generate
{
  public function __construct()
  {
  }

  public function generate_json()
  {
  }
}
function generate_svg_json(): array
{
  $return = [
    "metas" => [],
    "contents" => [],
    "meta_branches" => [],
    "meta_tags" => [],
    "_meta" => [
      "name" => "",
      "slug" => "",
      "ico" => "",
      "nameCn" => "",
      "description" => "",
      "type" => "",
      "contents" => [],
    ],
    "_content" => [
      "title" => "",
      "slug" => "",
      "ico" => "",
      "titleCn" => "",
      "description" => "",
      "type" => "",

      "metas" => [],
      "storage" => "img/ico/{{\$slug}}.ico",
    ],
  ];

  array_push($return['metas'], [
    "name" => "FontAwesome",
    "slug" => "fontawesome",
    "ico" => "",
    "nameCn" => "",
    "description" => "",
    "type" => "category",
    "contents" => [],
  ]);
  // @fortawesome/font-awesome
  $relativePath = "/lib/@fortawesome/fontawesome-free/6.5.1";
  $fontawesome = json_decode(file_get_contents(__DIR__ . '\..\lib\@fortawesome\fontawesome-free\6.5.1\metadata\icon-families.json'), true);
  // var_dump($fontawesome);
  foreach ($fontawesome as $key => $item) {

    foreach (array_keys($item['svgs']['classic']) as $classic) {
      array_push($return['contents'], [
        "title" => $item['label'],
        "slug" => $classic . '-' . $key,
        "type" => "svg",
        "relativePath" => "/lib/@fortawesome/fontawesome-free/6.5.1/svgs/$classic/$key.svg",
        "metas" => ["fontawesome", "fontawesome-free", $classic],
      ]);

      if (file_exists(__DIR__ . "/../svg/$classic/$key.svg")) {
        unlink(__DIR__ . "/../svg/$classic/$key.svg");
      }
    }
  }

  // SimpleIcons
  array_push($return['metas'], [
    "name" => "SimpleIcons",
    "slug" => "simple-icons",
    "ico" => "",
    "nameCn" => "",
    "description" => "",
    "type" => "category",
    "contents" => [],
  ]);
  $relativePath = "/lib/simple-icons/11.14.0";
  $simpleIcons = json_decode(file_get_contents(__DIR__ . '\..\lib\simple-icons\11.14.0\_data\simple-icons.json'), true);
  foreach ($simpleIcons['icons'] as $item) {
    $classic = "brands";
    // $url = parse_url($item['source']);

    // var_dump($url);
    // $file = pathinfo($url['host']);
    // var_dump($file);
    // exit;
    $key = isset($item['slug']) ? $item['slug'] : preg_replace(["/ |-|'|\/|\\\\|:|°|!|_/", "/\./", "/é|É/", "/Š/", "/Ż/"], ["", "dot", "e", "s", "z"], strtolower($item['title']));
    array_push($return['contents'], [
      "title" => $item['title'],
      "slug" => $classic . '-' . $key,
      "type" => "svg",
      "relativePath" => "/lib/simple-icons/11.14.0/icons/$key.svg",
      "hex" => $item["hex"],
      "metas" => ["simple-icons", $classic],
    ]);

    if (file_exists(__DIR__ . "/../svg/$classic/$key.svg")) {
      unlink(__DIR__ . "/../svg/$classic/$key.svg");
    }
  }



  // Bootstrap Icons
  array_push($return['metas'], [
    "name" => "Bootstrap Icons",
    "slug" => "bootstrap-icons",
    "ico" => "",
    "nameCn" => "",
    "description" => "",
    "type" => "category",
    "contents" => [],
  ]);
  $relativePath = "/lib/bootstrap-icons/1.11.3";
  $bootstrapIcons = json_decode(file_get_contents(__DIR__ . "/.." . $relativePath . "/bootstrap-icons.json"), true);

  // foreach ($bootstrapIcons as $key => $item) {
  //   $classic = "solid";
  //   // $url = parse_url($item['source']);

  //   // var_dump($url);
  //   // $file = pathinfo($url['host']);
  //   // var_dump($file);
  //   // exit;
  //   // $key = isset($item['slug']) ? $item['slug'] : preg_replace(["/ |-|'|\/|\\\\|:|°|!|_/", "/\./", "/é|É/", "/Š/", "/Ż/"], ["", "dot", "e", "s", "z"], strtolower($item['title']));
  //   array_push($return['contents'], [
  //     "title" => $key,
  //     "slug" => $classic . '-' . $key,
  //     "type" => "svg",
  //     "relativePath" => $relativePath . "/icons/$key.svg",
  //     "metas" => ["bootstrap-icons", $classic],
  //   ]);

  //   if (file_exists(__DIR__ . "/../svg/$classic/$key.svg")) {
  //     unlink(__DIR__ . "/../svg/$classic/$key.svg");
  //   }
  // }


  // Output
  file_put_contents(__DIR__ . '/../json/svg.json', json_encode($return));

  return $return;
}



$return = generate_svg_json();

echo json_encode([
  "data" => array_slice($return['contents'], 0, 100),
  "size" => 100,
  "page" => 1,
  "total" => sizeof($return['contents'])
]);
