<?php

/**
 * 
 */
if (!function_exists("is_laravel")) {
  function is_laravel()
  {
    return class_exists(\Illuminate\Foundation\Application::class);
  }
}
/**
 * 
 */
if (!function_exists("is_lumen")) {
  function is_lumen()
  {
    return class_exists(\Laravel\Lumen\Application::class);
  }
}