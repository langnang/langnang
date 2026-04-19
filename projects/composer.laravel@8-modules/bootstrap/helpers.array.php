<?php
if (!function_exists('is_item')) {
    function is_item($values)
    {
        if (!is_array($values)) return;
        return count($values) === count($values, COUNT_RECURSIVE);
    }
}
if (!function_exists('is_list')) {
    function is_list($values)
    {
        if (!is_array($values)) return;
        return count($values) !== count($values, COUNT_RECURSIVE);
    }
}
