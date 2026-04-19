<?php

function make_file() {}
function make_dir() {}


function file_put() {}
function file_get() {}
function file_path() {}
function file_info() {}
function file_download() {}
function file_url() {}
function file_delete() {}
function file_move() {}
function file_copy() {}
function filesOf($path)
{
    $return = \File::files($path);
    // var_dump($return);
    $return = array_map(function ($value) use ($path) {
        return substr($value, strlen($path) + 1);
    }, $return);
    // var_dump($return);
    return $return;
}
function depthFilesOf($path, $depth = 0) {}
function allFilesOf($path) {}

function dirsOf($path)
{
    $return = \File::directories($path);
    // var_dump($return);
    $return = array_map(function ($value) use ($path) {
        return substr($value, strlen($path) + 1);
    }, $return);
    // var_dump($return);
    return $return;
}
function depthDirsOf($path, $depth = 0) {}
function allDirsOf($path) {}
function dir_move() {}
function dir_delete() {}
function dir_clean() {}
