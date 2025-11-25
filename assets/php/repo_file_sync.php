<?php
/**
 * 仓库文件同步
 */
$config = [
    'path' => __DIR__ . '/../../',

    'file' => [],

    'dir' => [],
];
$syncFiles = [];

$syncDirs = [];

$files = scandir(__DIR__ . '/../../');

foreach ($files as $file) {
    if ($file == '.' || $file == '..') {
        continue;
    }
    $path = __DIR__ . '/../../' . $file;

    // var_dump(is_dir($path));
    // var_dump(filetype($path));
    if (is_dir($path)) {
        // echo "$path\n";
    } else {
        // echo "$path\n";
    }
}