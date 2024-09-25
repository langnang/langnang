<?php

namespace Illuminate\Database;

class QueryBuilder
{
  public $table;
  function connection() {}
  function table($tbname)
  {
    $this->$table = $tbname;
    return $this;
  }
  function select() {}
  function get() {}
  function first() {}
  function exists() {}
}
