<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;

class WebstackCategory extends Model
{
  // use ModelTree, AdminBuilder;

  public function children()
  {
    return $this->hasMany(static::class, 'parent_id');
  }

  public function sites()
  {
    return $this->hasMany(WebstackSite::class, 'category_id');
  }
}
