<?php

namespace Illuminate\Router\Models;

class Route
{
  public $name;
  public $method;
  public $pattern;
  public $query;
  public $params;
  public $callback;
  public $uri;
  function __construct($params) {}
}
